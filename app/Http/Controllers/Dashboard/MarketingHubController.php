<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\GoogleAdsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingHubController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        $branch = $business->branches->first();

        $suggestedKeywords = [
            ['keyword' => 'best ' . $business->category . ' Mumbai', 'intent' => 'High'],
            ['keyword' => $business->category . ' near me', 'intent' => 'High'],
        ];

        return view('dashboard.marketing-hub', compact('suggestedKeywords', 'branch'));
    }

    public function launchAds(Request $request, GoogleAdsService $adsService)
    {
        $request->validate([
            'budget' => 'required|numeric|min:500',
            'radius' => 'required|numeric|min:1|max:50',
            'keywords' => 'required|string',
        ]);

        $branch = Auth::user()->currentBusiness->branches->first();
        $campaign = $adsService->launchLocalCampaign($branch, $request->all());

        if ($campaign) {
            return redirect()->back()->with('success', 'Local Ads Campaign launched! ID: ' . $campaign['campaign_id']);
        }

        return redirect()->back()->with('error', 'Failed to launch campaign.');
    }
}
