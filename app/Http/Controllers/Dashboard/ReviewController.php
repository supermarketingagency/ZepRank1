<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ReviewSession;
use App\Services\Review\AutoReplyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(AutoReplyService $replyService)
    {
        $business = Auth::user()->currentBusiness;
        $reviews = ReviewSession::whereIn('branch_id', $business->branches->pluck('id'))
            ->whereNotNull('star_rating')
            ->with(['branch', 'business'])
            ->latest()
            ->paginate(20);

        // Add suggested replies to each review
        foreach($reviews as $review) {
            if ($review->star_rating >= 4) {
                $review->suggested_reply = $replyService->suggestReply($review);
            }
        }

        return view('dashboard.reviews', compact('business', 'reviews'));
    }
}
