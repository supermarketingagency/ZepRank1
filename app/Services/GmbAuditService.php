<?php

namespace App\Services;

use App\Models\Branch;
use App\Services\AI\AIProviderFactory;
use Illuminate\Support\Facades\Log;

class GmbAuditService
{
    public function generateAuditSuggestions(Branch $branch)
    {
        $business = $branch->business;

        $providerName = $business->ai_provider ?? config('services.ai.default_provider', 'groq');
        $model = $business->ai_model ?? config('services.ai.default_model', 'llama-3.1-70b-versatile');
        $apiKey = $business->ai_api_key_encrypted ?? config('services.ai.api_key');

        $provider = AIProviderFactory::make($providerName, $model, $apiKey ?: '');

        $promptData = [
            'business_name' => $business->name,
            'category' => $business->category,
            'description' => $branch->business_description,
            'keywords' => $branch->target_keywords,
            'rating' => $branch->google_rating,
        ];

        try {
            // Simulated audit results - in real app would use $provider to analyze and suggest
            return [
                'score' => 78,
                'critical_issues' => [
                    'Missing operational hours for public holidays.',
                    'Profile description is under 250 characters (SEO suboptimal).',
                ],
                'optimization_suggestions' => [
                    'description' => "Optimized: $business->name is a premier $business->category located in $branch->address. We specialize in high-quality services and customer satisfaction. Visit us for the best experience in town.",
                    'category' => "Primary: $business->category | Secondary: Service Provider, Local Business",
                    'keywords_to_add' => "best $business->category, $business->category near me, affordable $business->category",
                ],
                'keyword_gap' => [
                    'Top trending keywords in your area for ' . $business->category . ': "quick service", "authentic vibe", "family friendly".'
                ]
            ];
        } catch (\Exception $e) {
            Log::error('GMB Audit failed: ' . $e->getMessage());
            return null;
        }
    }
}
