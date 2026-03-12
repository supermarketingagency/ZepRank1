<?php

namespace App\Services\AI;

use App\Models\ReviewSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AIReviewService
{
    public function generateReviewDrafts(ReviewSession $session)
    {
        $branch = $session->branch;
        $business = $branch->business;

        // Simplify provider resolution: Use admin-set global provider unless business brings their own
        $providerName = $business->ai_provider ?? config('services.ai.default_provider', 'groq');
        $model = $business->ai_model ?? config('services.ai.default_model', 'llama-3.1-70b-versatile');
        $apiKey = $business->ai_api_key_encrypted ?? config('services.ai.api_key');

        $provider = AIProviderFactory::make($providerName, $model, $apiKey ?: '');

        $promptData = [
            'business_name' => $business->name,
            'category' => $business->category,
            'star_rating' => $session->star_rating,
        ];

        try {
            $drafts = $provider->generateReviewDrafts($promptData);

            if (empty($drafts)) {
                $drafts = $this->getFallbackDrafts($business->category);
            }

            // Clean existing drafts for this session to avoid duplicates on retry
            DB::table('ai_review_drafts')->where('review_session_id', $session->id)->delete();

            foreach ($drafts as $index => $content) {
                DB::table('ai_review_drafts')->insert([
                    'review_session_id' => $session->id,
                    'draft_number' => $index + 1,
                    'content' => $content,
                    'created_at' => now(),
                    'updated_at' => now(),
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
