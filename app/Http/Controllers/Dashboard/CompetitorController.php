<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\CompetitorAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitorController extends Controller
{
    public function index(CompetitorAnalysisService $competitorService)
    {
        $business = Auth::user()->currentBusiness;
        $branch = $business->branches->first(); // Default to first branch for MVP

        if (!$branch) {
            return redirect()->route('dashboard.business')->with('error', 'Please add a branch first.');
        }

        $data = $competitorService->getBenchmarkingData($branch);

        return view('dashboard.competitors', compact('data', 'branch'));
    }
}
