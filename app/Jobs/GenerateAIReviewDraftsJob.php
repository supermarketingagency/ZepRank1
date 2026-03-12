<?php

namespace App\Jobs;

use App\Models\ReviewSession;
use App\Services\AI\AIReviewService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateAIReviewDraftsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sessionId;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function handle(AIReviewService $aiService): void
    {
        $session = ReviewSession::find($this->sessionId);
        if ($session) {
            $aiService->generateReviewDrafts($session);
        }
    }
}
