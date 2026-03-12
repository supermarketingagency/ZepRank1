<?php

namespace App\Services\AI;

use App\Models\Branch;
use App\Models\ReviewSession;
use Illuminate\Support\Facades\Log;

class AIReviewService
{
    public function generateReviewDrafts(ReviewSession $session)
    {
        $branch = $session->branch;
        $business = $branch->business;

        $providerName = $branch->ai_provider_override ?? $business->ai_provider ?? 'groq';
        $model = $branch->ai_model_override ?? $business->ai_model ?? 'llama-3.1-70b-versatile';
        $apiKey = $branch->ai_api_key_encrypted ?? $business->ai_api_key_encrypted ?? config('services.ai.groq_api_key', '');

        $provider = AIProviderFactory::make($providerName, $model, $apiKey);

        $promptData = [
            'business_name' => $business->name,
            'branch_name' => $branch->name,
            'category' => $business->category,
            'star_rating' => $session->star_rating,
            'city' => $business->city,
        ];

        try {
            $drafts = $provider->generateReviewDrafts($promptData);

            foreach ($drafts as $index => $content) {
                \App\Models\AIGenerationLog::create([
                    'business_id' => $business->id,
                    'branch_id' => $branch->id,
                    'review_session_id' => $session->id,
                    'provider' => $providerName,
                    'model' => $model,
                    'operation' => 'review_generation',
                    'success' => true,
                ]);

                // Store in session related drafts table
                \Illuminate\Support\Facades\DB::table('ai_review_drafts')->insert([
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
            return [];
        }
    }
}
