<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PrivateFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        $feedbacks = PrivateFeedback::whereIn('branch_id', $business->branches->pluck('id'))
            ->with('branch')
            ->latest()
            ->paginate(20);

        return view('dashboard.feedback', compact('business', 'feedbacks'));
    }
}
