<?php

namespace App\Services\AI\Providers;

use App\Services\AI\AIProviderInterface;
use Illuminate\Support\Facades\Http;

class GeminiProvider implements AIProviderInterface
{
    protected $apiKey;
    protected $model;

    public function __construct(string $apiKey, string $model = 'gemini-pro')
    {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    public function generateReviewDrafts(array $promptData): array
    {
        if (empty($this->apiKey)) {
            return [
                "Fantastic " . ($promptData['category'] ?? 'service') . ". Very happy with the outcome.",
                "Great value and quality. " . ($promptData['business_name'] ?? 'This place') . " is a gem.",
                "Smooth experience from start to finish. Highly recommended."
            ];
        }

        return [];
    }

    public function analyseSentiment(string $text): array
    {
        return ['label' => 'positive', 'score' => 0.85];
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    public function getProviderName(): string
    {
        return 'gemini';
    }
}
