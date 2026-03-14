<?php

namespace App\Services\AI;

use App\Services\AI\Providers\GroqProvider;
use App\Services\AI\Providers\OpenAIProvider;
use App\Services\AI\Providers\GeminiProvider;

class AIProviderFactory
{
    public static function make(string $provider, string $model, string $apiKey): AIProviderInterface
    {
        return match ($provider) {
            'groq' => new GroqProvider($apiKey, $model),
            'openai' => new OpenAIProvider($apiKey, $model),
            'gemini' => new GeminiProvider($apiKey, $model),
            default => new GroqProvider($apiKey, $model), // Default to Groq
        };
    }
}
