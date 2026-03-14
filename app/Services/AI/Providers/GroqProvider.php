<?php

namespace App\Services\AI\Providers;

use App\Services\AI\AIProviderInterface;
use Illuminate\Support\Facades\Http;

class GroqProvider implements AIProviderInterface
{
    protected $apiKey;
    protected $model;

    public function __construct(string $apiKey, string $model = 'llama-3.1-70b-versatile')
    {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    public function generateReviewDrafts(array $promptData): array
    {
        // Mocking for now if API key is not set
        if (empty($this->apiKey)) {
            $cat = $promptData['category'] ?? 'service';
            $biz = $promptData['business_name'] ?? 'this place';
            $desc = $promptData['business_description'] ?? '';
            $keywords = $promptData['target_keywords'] ?? '';

            if ($desc) {
                return [
                    "I had an amazing experience at $biz. $desc The keywords that come to mind are $keywords.",
                    "Truly impressed with $biz. Their focus on $keywords really shows. $desc",
                    "Best $cat experience! $desc Highly recommended for their professional approach."
                ];
            }

            return [
                "The $cat at $biz was absolutely top notch! Highly recommend.",
                "Great experience! Will definitely come back again soon. $biz is excellent.",
                "Loved the vibe and the quality of everything. A solid 5 stars!"
            ];
        }

        // Real implementation would be:
        // $response = Http::withToken($this->apiKey)->post('https://api.groq.com/...', [...]);
        return [];
    }

    public function analyseSentiment(string $text): array
    {
        return ['label' => 'positive', 'score' => 0.9];
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    public function getProviderName(): string
    {
        return 'groq';
    }
}
