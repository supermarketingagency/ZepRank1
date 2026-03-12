<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        $managedBusinesses = Business::whereHas('owner', function($q) {
            // In a real app, we'd check the manager_client_assignments table
            // For MVP, let's assume businesses with reseller_id or similar
        })->get();

        return view('manager.dashboard', compact('managedBusinesses'));
    }
}
