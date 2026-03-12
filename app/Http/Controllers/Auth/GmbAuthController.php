<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GoogleProfileConnection;
use App\Services\GoogleProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GmbAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/business.manage'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    public function handleCallback(GoogleProfileService $googleProfileService)
    {
        try {
            $user = Socialite::driver('google')->user();

            $connection = GoogleProfileConnection::updateOrCreate(
                ['business_id' => Auth::user()->current_business_id],
                [
                    'google_account_id' => $user->id,
                    'access_token' => $user->token,
                    'refresh_token' => $user->refreshToken,
                    'expires_at' => now()->addSeconds($user->expiresIn),
                ]
            );

            $googleProfileService->fetchAndSyncProfile($connection);

            return redirect()->route('dashboard.business')->with('success', 'GMB Account connected and synced successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.business')->with('error', 'Failed to connect GMB account: ' . $e->getMessage());
        }
    }
}
