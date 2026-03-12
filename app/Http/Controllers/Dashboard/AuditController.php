<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\GmbAuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index(GmbAuditService $auditService)
    {
        $business = Auth::user()->currentBusiness;
        $branch = $business->branches->first();

        if (!$branch) {
            return redirect()->route('dashboard.business')->with('error', 'Please add a branch first.');
        }

        $auditData = $auditService->generateAuditSuggestions($branch);

        return view('dashboard.audit', compact('auditData', 'branch'));
    }
}
