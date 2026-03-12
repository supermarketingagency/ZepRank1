<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Facades\Log;

class GoogleAdsService
{
    public function launchLocalCampaign(Branch $branch, array $campaignData)
    {
        // campaignData: ['budget' => 1000, 'radius' => 5, 'keywords' => '...']

        try {
            // Mocking Google Ads API call (Local campaigns)
            Log::info("Launching Google Ads campaign for branch " . $branch->id . " with budget " . $campaignData['budget']);

            return [
                'campaign_id' => 'ADS-' . strtoupper(uniqid()),
                'status' => 'active',
                'start_date' => now()->toDateString(),
            ];
        } catch (\Exception $e) {
            Log::error("Google Ads launch failed: " . $e->getMessage());
            return null;
        }
    }

    public function getPerformanceMetrics(string $campaignId)
    {
        return [
            'impressions' => rand(1000, 5000),
            'clicks' => rand(50, 200),
            'conversions' => rand(5, 20),
            'spend' => rand(100, 500),
        ];
    }
}
