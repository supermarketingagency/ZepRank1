<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\GoogleProfileConnection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleProfileService
{
    public function fetchAndSyncProfile(GoogleProfileConnection $connection)
    {
        $accessToken = $connection->access_token;
        $locationId = $connection->google_location_id;

        if (!$locationId) {
            return $this->discoverLocations($connection);
        }

        try {
            // Mocking GBP API call
            // In real implementation: Http::withToken($accessToken)->get("https://mybusinessbusinessinformation.googleapis.com/v1/$locationId")

            $profileData = [
                'title' => 'Verif Coffee House',
                'categories' => ['primaryCategory' => 'Cafe'],
                'description' => 'Experience the best artisan coffee in Mumbai. We offer a wide range of brews and snacks in a cozy atmosphere.',
                'metadata' => ['newReviewUrl' => 'https://search.google.com/local/writereview?placeid=ChIJN1t_tDeuEmsRUsoyG83OBY8'],
                'storeCode' => 'MUM001',
            ];

            $connection->update([
                'profile_data' => $profileData
            ]);

            $branch = $connection->branch ?? $connection->business->branches()->first();

            if ($branch) {
                $branch->update([
                    'name' => $profileData['title'],
                    'google_review_url' => $profileData['metadata']['newReviewUrl'],
                ]);

                $branch->business->update([
                    'name' => $profileData['title'],
                    'category' => $profileData['categories']['primaryCategory'],
                ]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('GBP Sync failed: ' . $e->getMessage());
            return false;
        }
    }

    protected function discoverLocations(GoogleProfileConnection $connection)
    {
        // Discover and return available locations for selection
        return [];
    }
}
