<?php

namespace App\Services;

use App\Models\GoogleReview;
use App\Services\AI\AIProviderFactory;
use Illuminate\Support\Facades\Log;

class AutoReplyService
{
    public function generateReplySuggestion(GoogleReview $review)
    {
        $business = $review->business;
        $branch = $review->branch;

        $providerName = $business->ai_provider ?? config('services.ai.default_provider', 'groq');
        $model = $business->ai_model ?? config('services.ai.default_model', 'llama-3.1-70b-versatile');
        $apiKey = $business->ai_api_key_encrypted ?? config('services.ai.api_key');

        $provider = AIProviderFactory::make($providerName, $model, $apiKey ?: '');

        $promptData = [
            'business_name' => $business->name,
            'category' => $business->category,
            'reviewer_name' => $review->reviewer_name,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'keywords' => $branch->target_keywords,
        ];

        try {
            // Simulated AI call - in real app would be $provider->generateReply($promptData)
            // For now, let's use a standard template if provider doesn't support direct reply generation yet
            $reply = $this->getMockReply($promptData);

            $review->reply_suggestion = $reply;
            $review->save();

            return $reply;
        } catch (\Exception $e) {
            Log::error('AI Reply Generation failed: ' . $e->getMessage());
            return null;
        }
    }

    protected function getMockReply($data)
    {
        $name = explode(' ', $data['reviewer_name'])[0];
        $biz = $data['business_name'];

        if ($data['rating'] >= 4) {
            return "Hi $name, thank you so much for your kind words! We are thrilled that you enjoyed your experience at $biz. We look forward to seeing you again soon!";
        } else {
            return "Hi $name, we're sorry to hear that your experience wasn't up to our usual standards. We appreciate your feedback and will use it to improve our services. Please feel free to reach out to us directly.";
        }
    }
}
