<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ReviewSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        // For MVP, we'll fetch businesses that the user has a relation with.
        // In full implementation, we'd check a many-to-many manager_client_assignments table.
        $managedBusinesses = Business::with(['branches'])
            ->where('owner_user_id', '!=', Auth::id()) // Assuming they manage others
            ->orWhere('id', Auth::user()->current_business_id) // Or their own
            ->get();

        $totalReviews = ReviewSession::whereIn('branch_id', function($query) use ($managedBusinesses) {
            $query->select('id')->from('branches')->whereIn('business_id', $managedBusinesses->pluck('id'));
        })->where('google_redirect_completed', true)->count();

        $avgRating = ReviewSession::whereIn('branch_id', function($query) use ($managedBusinesses) {
            $query->select('id')->from('branches')->whereIn('business_id', $managedBusinesses->pluck('id'));
        })->where('google_redirect_completed', true)->avg('star_rating') ?? 0;

        return view('manager.dashboard', compact('managedBusinesses', 'totalReviews', 'avgRating'));
    }
}
