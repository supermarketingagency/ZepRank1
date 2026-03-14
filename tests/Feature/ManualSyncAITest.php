<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Business;
use App\Models\ReviewSession;
use App\Models\User;
use App\Services\AI\AIReviewService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManualSyncAITest extends TestCase
{
    use RefreshDatabase;

    public function test_ai_generation_incorporates_manual_sync_data()
    {
        $user = User::factory()->create();
        $business = Business::create([
            'owner_user_id' => $user->id,
            'name' => 'Gourmet Pizza Restaurant',
            'slug' => 'gourmet-pizza',
            'category' => 'Restaurant',
            'status' => 'active',
            'onboarding_completed' => true,
        ]);

        $user->update(['current_business_id' => $business->id]);

        $branch = Branch::create([
            'business_id' => $business->id,
            'name' => 'Main Branch',
            'slug' => 'main-branch',
            'address' => '123 Pizza St',
            'business_description' => 'Authentic wood-fired pizzas with organic toppings.',
            'target_keywords' => ['wood-fired', 'organic', 'gourmet'],
            'google_review_url' => 'https://google.com/maps/restaurant',
        ]);

        $session = ReviewSession::create([
            'branch_id' => $branch->id,
            'business_id' => $business->id,
            'session_token' => 'test-token',
            'touchpoint_type' => 'qr',
            'star_rating' => 5,
        ]);

        $aiService = app(AIReviewService::class);
        $drafts = $aiService->generateReviewDrafts($session);

        $this->assertNotEmpty($drafts);

        $found = false;
        foreach ($drafts as $draft) {
            if (str_contains($draft, 'wood-fired') || str_contains($draft, 'organic')) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found, 'AI drafts did not contain information from manual sync data.');
    }

    public function test_manual_sync_endpoint_updates_branch_data()
    {
        $this->withoutMiddleware(\App\Http\Middleware\RedirectIfInstalled::class);

        $user = User::factory()->create([
            'primary_role' => 'business_owner',
        ]);

        $business = Business::withoutGlobalScopes()->create([
            'owner_user_id' => $user->id,
            'name' => 'Dental Care Clinic',
            'slug' => 'dental-care-sync',
            'category' => 'Healthcare',
            'status' => 'active',
            'onboarding_completed' => true,
        ]);

        $user->current_business_id = $business->id;
        $user->save();

        $branch = Branch::withoutGlobalScopes()->create([
            'business_id' => $business->id,
            'name' => 'City Dental Clinic',
            'slug' => 'city-dental-sync',
        ]);

        $response = $this->actingAs($user->fresh())->post(route('dashboard.business.manual-sync'), [
            'maps_url' => 'https://www.google.com/maps/place/clinic-id',
        ]);

        $response->assertRedirect();

        $branch = Branch::withoutGlobalScopes()->find($branch->id);
        $this->assertNotNull($branch->business_description, 'Business description should not be null after sync');
    }
}
