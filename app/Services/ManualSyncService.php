<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Facades\Log;

class ManualSyncService
{
    /**
     * Simulates fetching business profile data from a Google Maps URL.
     * In production, this would use a web scraper or an LLM to extract details from the public profile.
     */
    public function syncFromUrl(Branch $branch, string $url)
    {
        Log::info("Manual sync triggered for branch {$branch->id} from URL: {$url}");

        // Logic based on common industry keywords to "simulate" web extraction
        $name = strtolower($branch->name);
        $biz = $branch->business()->withoutGlobalScopes()->first();
        $category = $biz ? strtolower($biz->category) : '';

        $description = "A well-regarded establishment in its field, providing quality service to its customers.";
        $keywords = ['quality', 'professional', 'service'];

        if (str_contains($name, 'restaurant') || str_contains($name, 'cafe') || str_contains($category, 'restaurant')) {
            $description = "Popular dining destination known for its diverse menu, fresh ingredients, and exceptional culinary experience. The atmosphere is cozy and perfect for both casual and formal dining.";
            $keywords = ['delicious food', 'fresh ingredients', 'cozy atmosphere', 'quick service', 'friendly staff'];
        } elseif (str_contains($name, 'clinic') || str_contains($name, 'hospital') || str_contains($category, 'health')) {
            $description = "Premier healthcare facility providing comprehensive medical care with a focus on patient comfort and advanced treatment options. Managed by a team of highly qualified professionals.";
            $keywords = ['patient care', 'expert doctors', 'hygienic environment', 'modern facilities', 'reliable'];
        } elseif (str_contains($name, 'salon') || str_contains($name, 'spa') || str_contains($category, 'beauty')) {
            $description = "Luxury wellness and beauty studio offering high-end treatments, professional styling, and a serene environment designed for ultimate relaxation and rejuvenation.";
            $keywords = ['luxury', 'professional styling', 'serene atmosphere', 'relaxing treatments', 'expert staff'];
        } elseif (str_contains($name, 'hotel') || str_contains($category, 'hospitality')) {
            $description = "Premium hospitality establishment offering comfortable stays, world-class amenities, and top-tier customer service in a prime location.";
            $keywords = ['comfortable stay', 'prime location', 'great amenities', 'hospitable staff', 'clean rooms'];
        }

        // Update the branch with fetched data
        $branch->update([
            'business_description' => $description,
            'target_keywords' => $keywords,
            'last_google_sync' => now(),
        ]);

        return $branch;
    }
}
