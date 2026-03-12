<?php

namespace App\Jobs;

use App\Models\Branch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncGmbAnalyticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $branch;

    /**
     * Create a new job instance.
     */
    public function __construct(Branch $branch = null)
    {
        $this->branch = $branch;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->branch) {
            $this->syncBranch($this->branch);
        } else {
            // Sync all active branches with google connections
            Branch::where('status', 'active')->each(function ($branch) {
                $this->syncBranch($branch);
            });
        }
    }

    protected function syncBranch(Branch $branch)
    {
        Log::info("Syncing GMB Analytics for branch: {$branch->id}");

        // In a real implementation, we would use the Google My Business API here.
        // For this task, we will simulate the data fetching.

        // Simulating random review count and rating growth
        $old_count = $branch->google_review_count ?? 0;
        $new_reviews = rand(0, 5);
        $branch->google_review_count = $old_count + $new_reviews;

        $old_rating = $branch->google_rating ?? 4.0;
        $branch->google_rating = min(5.0, max(1.0, $old_rating + (rand(-1, 2) / 10)));

        $branch->last_google_sync = now();
        $branch->save();

        Log::info("GMB Analytics synced for branch: {$branch->id}. New count: {$branch->google_review_count}, New rating: {$branch->google_rating}");
    }
}
