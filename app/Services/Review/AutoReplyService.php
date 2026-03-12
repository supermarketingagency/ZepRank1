<?php

namespace App\Services\Review;

use App\Models\AIReviewDraft;
use App\Models\ReviewSession;
use App\Services\AI\AIProviderFactory;

class AutoReplyService
{
    public function suggestReply(ReviewSession $session)
    {
        $branch = $session->branch;
        $business = $branch->business;

        $providerName = $branch->ai_provider_override ?? $business->ai_provider ?? 'groq';
        $model = $branch->ai_model_override ?? $business->ai_model ?? 'llama-3.1-70b-versatile';
        $apiKey = $branch->ai_api_key_encrypted ?? $business->ai_api_key_encrypted ?? config('services.ai.groq_api_key', '');

        // If no API key, return a generic helpful response
        if (empty($apiKey)) {
            $replies = [
                "Thank you so much for your kind words! We're thrilled you enjoyed your visit.",
                "We appreciate your feedback! It was a pleasure serving you.",
                "Thanks for the {$session->star_rating}-star rating! Hope to see you again soon."
            ];
            return $replies[array_rand($replies)];
        }

        $provider = \App\Services\AI\AIProviderFactory::make($providerName, $model, $apiKey);

        // In a real implementation, we would call the AI provider here.
        // For now, return a more context-aware mock reply.
        return "Thank you for visiting {$business->name}! We're so glad you had a great experience at our {$branch->name} location. We look forward to seeing you again soon!";
    }
}
