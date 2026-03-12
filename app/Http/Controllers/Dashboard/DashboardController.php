<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ReviewSession;
use App\Models\PrivateFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        if (!$business) {
            return redirect()->route('onboarding');
        }

        $stats = [
            'total_reviews' => ReviewSession::whereIn('branch_id', $business->branches->pluck('id'))
                ->where('google_redirect_completed', true)
                ->count(),
            'avg_rating' => ReviewSession::whereIn('branch_id', $business->branches->pluck('id'))
                ->where('google_redirect_completed', true)
                ->avg('star_rating') ?? 0,
            'qr_scans' => ReviewSession::whereIn('branch_id', $business->branches->pluck('id'))
                ->where('touchpoint_type', 'qr')
                ->count(),
            'private_feedbacks' => PrivateFeedback::whereIn('branch_id', $business->branches->pluck('id'))
                ->count(),
        ];

        $recentActivity = ReviewSession::whereIn('branch_id', $business->branches->pluck('id'))
            ->with('branch')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('business', 'stats', 'recentActivity'));
    }
}
