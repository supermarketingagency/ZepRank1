<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\SyncGmbAnalyticsJob;

Schedule::command('queue:work --stop-when-empty --max-time=55')->everyMinute();

// Auto-fetch GMB Analytics every 3 hours
Schedule::job(new SyncGmbAnalyticsJob)->everyThreeHours();
