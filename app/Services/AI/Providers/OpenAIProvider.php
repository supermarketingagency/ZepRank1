<?php

namespace App\Services\AI\Providers;

use App\Services\AI\AIProviderInterface;
use Illuminate\Support\Facades\Http;

class OpenAIProvider implements AIProviderInterface
{
    protected $apiKey;
    protected $model;

    public function __construct(string $apiKey, string $model = 'gpt-4o')
    {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    public function generateReviewDrafts(array $promptData): array
    {
        if (empty($this->apiKey)) {
            return [
                "Exceptional experience at " . ($promptData['business_name'] ?? 'this business') . "! Everything was handled professionally.",
                "Highly impressed with the " . ($promptData['category'] ?? 'service') . ". Definitely a 5-star experience.",
                "Will be back! Great attention to detail and friendly staff."
            ];
        }

        // Real API call would happen here
        return [];
    }

    public function analyseSentiment(string $text): array
    {
        return ['label' => 'positive', 'score' => 0.95];
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    public function getProviderName(): string
    {
        return 'openai';
    }
}
