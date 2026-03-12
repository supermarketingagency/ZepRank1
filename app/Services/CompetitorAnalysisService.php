<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Competitor;
use Illuminate\Support\Facades\Auth;

class CompetitorAnalysisService
{
    public function getBenchmarkingData(Branch $branch)
    {
        $competitors = Competitor::where('branch_id', $branch->id)->get();

        if ($competitors->isEmpty()) {
            $this->seedSimulatedCompetitors($branch);
            $competitors = Competitor::where('branch_id', $branch->id)->get();
        }

        return [
            'branch' => [
                'name' => 'Your Branch (' . $branch->name . ')',
                'rating' => (float) ($branch->google_rating ?? 4.0),
                'reviews' => (int) ($branch->google_review_count ?? 10),
            ],
            'competitors' => $competitors->map(fn($c) => [
                'name' => $c->name,
                'rating' => (float) $c->google_rating,
                'reviews' => (int) $c->google_review_count,
            ])
        ];
    }

    protected function seedSimulatedCompetitors(Branch $branch)
    {
        $names = ['Competitor A', 'Top Rated Rival', 'City Best Services', 'Prime Solutions', 'Expert Team'];

        foreach ($names as $name) {
            Competitor::create([
                'business_id' => $branch->business_id,
                'branch_id' => $branch->id,
                'name' => $name,
                'google_rating' => (rand(35, 49) / 10),
                'google_review_count' => rand(50, 500),
            ]);
        }
    }
}
