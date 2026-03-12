<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WidgetController extends Controller
{
    public function index()
    {
        $business = Auth::user()->currentBusiness;
        return view('dashboard.widgets', compact('business'));
    }
}
