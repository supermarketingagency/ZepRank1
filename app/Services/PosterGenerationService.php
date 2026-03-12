<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Festival;
use App\Models\BrandedPoster;
use App\Services\AI\AIImageService;
use Illuminate\Support\Facades\Log;

class PosterGenerationService
{
    protected $aiImageService;

    public function __construct(AIImageService $aiImageService)
    {
        $this->aiImageService = $aiImageService;
    }

    public function generateForFestival(Branch $branch, Festival $festival)
    {
        $business = $branch->business;
        $prompt = "A professional, clean, minimalist festival poster for " . $festival->name .
                  " customized for a " . $business->category . " business named " . $business->name .
                  ". Colors: " . ($business->primary_color ?? 'Blue') . ". Inclusion of holiday vibes.";

        $brandConfig = [
            'logo_url' => $business->logo_path,
            'primary_color' => $business->primary_color,
            'business_name' => $business->name,
        ];

        try {
            $imagePath = $this->aiImageService->generateBrandedImage($prompt, $brandConfig);

            if ($imagePath) {
                return BrandedPoster::create([
                    'business_id' => $business->id,
                    'branch_id' => $branch->id,
                    'festival_id' => $festival->id,
                    'image_path' => $imagePath,
                    'caption' => "Happy " . $festival->name . " from " . $business->name . "! We are celebrating with special offers for our local community. #festival #localbusiness",
                    'status' => 'generated'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Poster Generation Service failed: ' . $e->getMessage());
        }

        return null;
    }
}
