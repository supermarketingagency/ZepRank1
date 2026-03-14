<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessManagementController extends Controller
{
    public function index()
    {
        $businesses = Business::with('owner')->latest()->paginate(20);
        return view('admin.businesses.index', compact('businesses'));
    }

    public function show(Business $business)
    {
        $business->load(['owner', 'branches', 'subscription.plan']);
        return view('admin.businesses.show', compact('business'));
    }

    public function updateStatus(Request $request, Business $business)
    {
        $request->validate([
            'status' => 'required|in:active,suspended,cancelled,trial'
        ]);

        $business->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Business status updated to ' . $request->status);
    }
}
