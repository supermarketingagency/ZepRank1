<?php

namespace App\Services\AI;

use App\Services\AI\Providers\GroqProvider;

class AIProviderFactory
{
    public static function make(string $provider, string $model, string $apiKey): AIProviderInterface
    {
        return match ($provider) {
            'groq' => new GroqProvider($apiKey, $model),
            // Other providers like openai, gemini, etc. would be added here
            default => new GroqProvider($apiKey, $model), // Default to Groq
        };
    }
}
