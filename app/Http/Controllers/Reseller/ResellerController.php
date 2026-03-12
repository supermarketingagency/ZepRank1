<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResellerController extends Controller
{
    public function index()
    {
        $reseller = Reseller::where('user_id', Auth::id())->first();

        // Count customers under this reseller
        $customerCount = Business::where('reseller_id', $reseller->id ?? null)->count();

        return view('reseller.dashboard', compact('reseller', 'customerCount'));
    }
}
