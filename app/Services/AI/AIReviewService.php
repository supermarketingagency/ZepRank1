<?php

namespace App\Services\AI;

use App\Models\ReviewSession;
use App\Models\AIReviewDraft;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Log;

class AIReviewService
{
    public function generateReviewDrafts(ReviewSession $session)
    {
        $branch = $session->branch;
        $business = $branch->business;

        // Resolve Global Settings as fallbacks
        $globalSettings = PlatformSetting::whereIn('key', [
            'ai_default_provider',
            'ai_default_model',
            'openai_api_key',
            'gemini_api_key',
            'groq_api_key'
        ])->get()->pluck('value', 'key');

        $providerName = $branch->ai_provider_override ?? $business->ai_provider ?? $globalSettings['ai_default_provider'] ?? 'groq';
        $model = $branch->ai_model_override ?? $business->ai_model ?? $globalSettings['ai_default_model'] ?? 'llama-3.1-70b-versatile';

        // Resolve API key based on provider with multi-level overrides
        $apiKey = $branch->ai_api_key_encrypted ?? $business->ai_api_key_encrypted;

        if (!$apiKey) {
            $apiKey = match($providerName) {
                'openai' => $globalSettings['openai_api_key'] ?? null,
                'gemini' => $globalSettings['gemini_api_key'] ?? null,
                'groq'   => $globalSettings['groq_api_key'] ?? null,
                default  => null
            };
        }

        $provider = AIProviderFactory::make($providerName, $model, $apiKey ?: '');

        $promptData = [
            'business_name' => $business->name,
            'category' => $business->category,
            'star_rating' => $session->star_rating,
            'business_description' => $branch->business_description,
            'target_keywords' => is_array($branch->target_keywords) ? implode(', ', $branch->target_keywords) : $branch->target_keywords,
        ];

        try {
            $drafts = $provider->generateReviewDrafts($promptData);

            if (empty($drafts)) {
                $drafts = $this->getFallbackDrafts($business->category);
            }

            // Clean existing drafts for this session to avoid duplicates on retry
            AIReviewDraft::where('review_session_id', $session->id)->delete();

            foreach ($drafts as $index => $content) {
                AIReviewDraft::create([
                    'review_session_id' => $session->id,
                    'business_id' => $session->business_id,
                    'draft_number' => $index + 1,
                    'content' => $content,
                ]);
            }

            return $drafts;
        } catch (\Exception $e) {
            Log::error('AI Review Generation failed: ' . $e->getMessage());
            return $this->getFallbackDrafts($business->category);
        }
    }

    protected function getFallbackDrafts($category)
    {
        return [
            "Great experience! The quality and service were excellent. Highly recommended for anyone looking for a top-tier $category.",
            "I had a wonderful time here. Everything from the staff to the atmosphere was perfect. Best $category in town!",
            "Really impressed with the attention to detail. Will definitely be coming back again soon."
        ];
    }
}
