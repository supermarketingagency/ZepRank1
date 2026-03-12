<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $business = $user->currentBusiness;

        if ($business && $business->onboarding_completed) {
            return redirect()->route('dashboard');
        }

        $step = $business ? $business->onboarding_step : 1;
        if ($step > 5) $step = 5;

        return view('dashboard.onboarding.step' . $step, compact('business', 'step'));
    }

    public function step1(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $business = Business::updateOrCreate(
            ['owner_user_id' => $user->id, 'onboarding_completed' => false],
            [
                'name' => $request->name,
                'category' => $request->category,
                'city' => $request->city,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'onboarding_step' => 2
            ]
        );

        $user->current_business_id = $business->id;
        $user->save();

        return redirect()->route('onboarding');
    }

    public function step2(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'google_review_url' => 'required|url',
        ]);

        $user = Auth::user();
        $business = $user->currentBusiness ?: $user->ownedBusinesses()->where('onboarding_completed', false)->first();

        if (!$business) {
            return redirect()->route('onboarding');
        }

        $branch = Branch::updateOrCreate(
            ['business_id' => $business->id, 'name' => $request->branch_name],
            [
                'slug' => Str::slug($request->branch_name) . '-' . Str::random(5),
                'google_review_url' => $request->google_review_url,
            ]
        );

        $business->update(['onboarding_step' => 3]);

        return redirect()->route('onboarding');
    }

    public function step3(Request $request)
    {
        $request->validate([
            'threshold' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $business = $user->currentBusiness ?: $user->ownedBusinesses()->where('onboarding_completed', false)->first();

        if (!$business) {
            return redirect()->route('onboarding');
        }

        $branch = $business->branches()->first();

        if ($branch) {
            $branch->update(['negative_review_threshold' => $request->threshold]);
        }

        $business->update(['onboarding_step' => 4]);

        return redirect()->route('onboarding');
    }

    public function step4(Request $request)
    {
        $request->validate([
            'welcome_message' => 'nullable|string|max:500',
            'primary_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        $user = Auth::user();
        $business = $user->currentBusiness ?: $user->ownedBusinesses()->where('onboarding_completed', false)->first();

        if (!$business) {
            return redirect()->route('onboarding');
        }

        $business->update(['onboarding_step' => 5]);

        return redirect()->route('onboarding');
    }

    public function step5(Request $request)
    {
        $user = Auth::user();
        $business = $user->currentBusiness ?: $user->ownedBusinesses()->where('onboarding_completed', false)->first();

        if (!$business) {
            return redirect()->route('onboarding');
        }

        $business->update([
            'onboarding_completed' => true,
            'status' => 'active'
        ]);

        return redirect()->route('dashboard');
    }
}
