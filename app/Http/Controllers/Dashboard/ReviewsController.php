<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GoogleReview;
use App\Services\AutoReplyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        $reviews = GoogleReview::with('branch')
            ->orderBy('review_date', 'desc')
            ->paginate(10);

        return view('dashboard.reviews-management', compact('reviews'));
    }

    public function generateSuggestion(GoogleReview $review, AutoReplyService $autoReplyService)
    {
        $this->authorize('view', $review->business);

        $suggestion = $autoReplyService->generateReplySuggestion($review);

        return response()->json([
            'suggestion' => $suggestion
        ]);
    }
}
