<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        $branches = $business->branches;

        return view('dashboard.qr', compact('business', 'branches'));
    }
}
