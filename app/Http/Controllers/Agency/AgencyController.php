<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ReviewSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    public function index()
    {
        // For MVP, similar to Manager but with emphasis on Campaigns (simulated)
        $managedClients = Business::with(['branches'])
            ->where('owner_user_id', '!=', Auth::id())
            ->get();

        $totalCampaigns = 0; // Simulated
        $totalReviews = ReviewSession::whereIn('branch_id', function($query) use ($managedClients) {
            $query->select('id')->from('branches')->whereIn('business_id', $managedClients->pluck('id'));
        })->where('google_redirect_completed', true)->count();

        return view('agency.dashboard', compact('managedClients', 'totalCampaigns', 'totalReviews'));
    }
}
