<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIImageService
{
    public function generateBrandedImage(string $prompt, array $brandConfig)
    {
        // brandConfig: ['logo_url' => '...', 'primary_color' => '#...', 'business_name' => '...']

        try {
            // Simulated generation for Hostinger compatibility (no DALL-E overhead for now)
            // In real: $response = Http::withToken(config('ai.openai_key'))->post(...)

            $filename = "posters/gen_" . bin2hex(random_bytes(8)) . ".png";
            $storagePath = storage_path('app/public/' . $filename);

            if (!\Illuminate\Support\Facades\File::exists(dirname($storagePath))) {
                \Illuminate\Support\Facades\File::makeDirectory(dirname($storagePath), 0755, true);
            }

            // Create a colorful placeholder representing the "generated" AI poster
            $canvas = imagecreatetruecolor(1080, 1080);
            $bgColor = imagecolorallocate($canvas, random_int(100, 255), random_int(100, 255), random_int(100, 255));
            imagefill($canvas, 0, 0, $bgColor);

            // Add some "AI-ish" shapes
            for($i=0; $i<5; $i++) {
                $color = imagecolorallocate($canvas, random_int(0, 255), random_int(0, 255), random_int(0, 255));
                imagefilledellipse($canvas, random_int(0, 1080), random_int(0, 1080), random_int(200, 600), random_int(200, 600), $color);
            }

            imagepng($canvas, $storagePath);
            imagedestroy($canvas);

            return $filename;
        } catch (\Exception $e) {
            Log::error('AI Image Generation failed: ' . $e->getMessage());
            return null;
        }
    }
}
