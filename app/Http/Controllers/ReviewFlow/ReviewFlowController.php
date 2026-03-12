<?php

namespace App\Http\Controllers\ReviewFlow;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ReviewSession;
use App\Services\AI\AIReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewFlowController extends Controller
{
    public function start($slug)
    {
        $branch = Branch::where('slug', $slug)->firstOrFail();

        $session = ReviewSession::create([
            'branch_id' => $branch->id,
            'session_token' => Str::random(64),
            'touchpoint_type' => 'link',
        ]);

        return view('review-flow.landing', compact('branch', 'session'));
    }

    public function submitRating(Request $request, $slug)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'session_token' => 'required|string',
        ]);

        $branch = Branch::where('slug', $slug)->firstOrFail();
        $session = ReviewSession::where('session_token', $request->session_token)->firstOrFail();

        $route = 'google';
        if ($branch->review_filter_enabled) {
            $route = $request->rating >= $branch->negative_review_threshold ? 'google' : 'private_feedback';
        }

        $session->update([
            'star_rating' => $request->rating,
            'route' => $route,
        ]);

        // Simple Routing: Go straight to drafts/feedback
        if ($session->route === 'google') {
            // Generate drafts immediately to keep it simple for the user (no MCQ screen for MVP)
            $aiService = new AIReviewService();
            $aiService->generateReviewDrafts($session);

            return redirect()->route('review.drafts', ['slug' => $slug, 'token' => $session->session_token]);
        } else {
            return redirect()->route('review.feedback', ['slug' => $slug, 'token' => $session->session_token]);
        }
    }

    public function showDrafts($slug, Request $request)
    {
        $branch = Branch::where('slug', $slug)->firstOrFail();
        $session = ReviewSession::where('session_token', $request->token)->firstOrFail();
        $drafts = \Illuminate\Support\Facades\DB::table('ai_review_drafts')
            ->where('review_session_id', $session->id)
            ->get();

        return view('review-flow.drafts', compact('branch', 'session', 'drafts'));
    }

    public function googleRedirect($slug, Request $request)
    {
        $branch = Branch::where('slug', $slug)->firstOrFail();
        $session = ReviewSession::where('session_token', $request->token)->firstOrFail();
        $session->update(['google_redirect_completed' => true]);

        return redirect()->away($branch->google_review_url);
    }

    public function showPrivateFeedback($slug, Request $request)
    {
        $branch = Branch::where('slug', $slug)->firstOrFail();
        $session = ReviewSession::where('session_token', $request->token)->firstOrFail();

        return view('review-flow.feedback', compact('branch', 'session'));
    }
}
