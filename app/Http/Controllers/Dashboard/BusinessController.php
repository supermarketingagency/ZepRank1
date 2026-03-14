<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        $branches = $business->branches;

        return view('dashboard.business', compact('business', 'branches'));
    }

    public function manualSync(Request $request, \App\Services\ManualSyncService $syncService)
    {
        $request->validate([
            'maps_url' => 'required|url|regex:/google\.com\/maps/'
        ]);

        $user = Auth::user();

        // Robust finding of business
        $business = \App\Models\Business::withoutGlobalScopes()
            ->where('owner_user_id', $user->id)
            ->first();

        if (!$business) {
             return redirect()->route('dashboard.business')->with('error', 'No business found for user.');
        }

        $branch = \App\Models\Branch::withoutGlobalScopes()
            ->where('business_id', $business->id)
            ->first();

        if ($branch) {
            $branch->update(['google_review_url' => $request->maps_url]);
            $syncService->syncFromUrl($branch, $request->maps_url);
            return redirect()->route('dashboard.business')->with('success', 'Manual sync completed.');
        }

        return redirect()->route('dashboard.business')->with('error', 'Could not find a branch to sync.');
    }

    public function storeBranch(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'google_review_url' => 'required|url',
        ]);

        $business = Auth::user()->currentBusiness;
        $business->branches()->create([
            'name' => $request->name,
            'address' => $request->address,
            'google_review_url' => $request->google_review_url,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(5),
        ]);

        return redirect()->back()->with('success', 'Branch added successfully.');
    }

    public function updateBranch(Request $request, \App\Models\Branch $branch)
    {
        $this->authorize('update', $branch->business);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'google_review_url' => 'required|url',
            'negative_review_threshold' => 'required|integer|min:1|max:5',
        ]);

        $branch->update($request->only(['name', 'address', 'google_review_url', 'negative_review_threshold']));

        return redirect()->back()->with('success', 'Branch updated successfully.');
    }
}
