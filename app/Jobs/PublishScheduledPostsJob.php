<?php

namespace App\Jobs;

use App\Models\BrandedPoster;
use App\Services\GmbPostingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishScheduledPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GmbPostingService $postingService): void
    {
        $duePosts = BrandedPoster::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($duePosts as $post) {
            $postingService->publishToGmb($post);
        }
    }
}
