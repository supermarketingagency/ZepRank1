<?php

namespace App\Services\AI;

interface AIProviderInterface
{
    public function generateReviewDrafts(array $promptData): array;
    public function analyseSentiment(string $text): array;
    public function isAvailable(): bool;
    public function getProviderName(): string;
}
