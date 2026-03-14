<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfInstalled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware if running tests and not explicitly testing installation
        if (app()->environment('testing') && !$request->header('X-Testing-Installation')) {
            return $next($request);
        }

        // Fix for subfolder installation: bypass if accessing public/
        if (str_contains($request->getRequestUri(), '/public/')) {
            return $next($request);
        }

        $isInstalled = File::exists(storage_path('installed'));
        $isInstallPath = $request->is('install') || $request->is('install/*');

        // If not installed and not on install page, redirect to install
        if (!$isInstalled && !$isInstallPath) {
            return redirect('/install');
        }

        // If installed and trying to access install page, redirect to dashboard
        if ($isInstalled && $isInstallPath) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
