<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BrandedPoster;
use App\Services\GmbPostingService;
use Illuminate\Http\Request;

class SocialSchedulerController extends Controller
{
    public function index()
    {
        $scheduledPosts = BrandedPoster::whereIn('status', ['scheduled', 'posted'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('dashboard.scheduler', compact('scheduledPosts'));
    }

    public function schedule(Request $request, BrandedPoster $poster)
    {
        $request->validate([
            'scheduled_at' => 'required|date|after:now',
        ]);

        $poster->update([
            'status' => 'scheduled',
            'scheduled_at' => $request->scheduled_at
        ]);

        return redirect()->back()->with('success', 'Post scheduled successfully.');
    }

    public function postNow(BrandedPoster $poster, GmbPostingService $postingService)
    {
        if ($postingService->publishToGmb($poster)) {
            return redirect()->back()->with('success', 'Post published to GMB!');
        }

        return redirect()->back()->with('error', 'Failed to publish post. Check GMB connection.');
    }
}
