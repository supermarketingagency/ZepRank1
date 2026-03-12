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
            return [
                "The food here was amazing! The " . ($promptData['category'] ?? 'service') . " was top notch. Highly recommend.",
                "Great experience at " . ($promptData['business_name'] ?? 'this place') . ". Will definitely come back again.",
                "Loved the vibe and the quality of everything. A solid 5 stars!"
            ];
        }

        // Implementation of Groq API call would go here
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
