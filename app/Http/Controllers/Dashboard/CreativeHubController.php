<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Festival;
use App\Models\BrandedPoster;
use App\Services\PosterGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreativeHubController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        if (!$business) {
            return redirect()->route('onboarding');
        }

        $upcomingFestivals = Festival::where('festival_date', '>=', now())
            ->orderBy('festival_date')
            ->take(5)
            ->get();

        $generatedPosters = BrandedPoster::with(['festival', 'branch'])
            ->latest()
            ->take(12)
            ->get();

        return view('dashboard.creative-hub', compact('upcomingFestivals', 'generatedPosters'));
    }

    public function generate(Festival $festival, PosterGenerationService $posterService)
    {
        $branch = Auth::user()->currentBusiness->branches->first();
        $poster = $posterService->generateForFestival($branch, $festival);

        if ($poster) {
            return redirect()->back()->with('success', 'Poster generated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to generate poster.');
    }
}
