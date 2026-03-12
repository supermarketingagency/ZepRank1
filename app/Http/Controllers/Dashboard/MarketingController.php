<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        $branch = $business->branches->first();

        // Suggested Keywords for Google Ads
        $suggestedKeywords = [
            ['keyword' => 'best ' . $business->category . ' ' . $branch->address, 'intent' => 'High'],
            ['keyword' => $business->category . ' near me', 'intent' => 'High'],
            ['keyword' => 'affordable ' . $business->category, 'intent' => 'Medium'],
            ['keyword' => $business->name . ' reviews', 'intent' => 'Brand'],
        ];

        return view('dashboard.marketing', compact('suggestedKeywords', 'branch'));
    }
}
