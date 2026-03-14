<?php

namespace App\Http\Middleware;

use App\Models\Reseller;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DetectReseller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip if app is not installed yet to avoid DB errors
        if (!\Illuminate\Support\Facades\File::exists(storage_path('installed'))) {
            return $next($request);
        }

        $host = $request->getHost();
        $reseller = Reseller::where('custom_domain', $host)->first();

        if ($reseller) {
            View::share('reseller', $reseller);
            config(['app.reseller_id' => $reseller->id]);
            config(['app.brand_name' => $reseller->brand_name]);
        }

        return $next($request);
    }
}
