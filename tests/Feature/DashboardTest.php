<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Business;
use App\Models\Branch;
use App\Models\ReviewSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_correct_stats(): void
    {
        $user = User::factory()->create(['primary_role' => 'business_owner']);
        $business = Business::create([
            'owner_user_id' => $user->id,
            'name' => 'Test Business',
            'category' => 'Retail',
            'slug' => 'test-retail',
            'onboarding_completed' => true,
        ]);
        $user->update(['current_business_id' => $business->id]);
        $branch = Branch::create(['business_id' => $business->id, 'name' => 'Store 1', 'slug' => 'store-1']);

        // Mock 2 Google reviews
        ReviewSession::create(['branch_id' => $branch->id, 'session_token' => 't1', 'touchpoint_type' => 'qr', 'star_rating' => 5, 'google_redirect_completed' => true]);
        ReviewSession::create(['branch_id' => $branch->id, 'session_token' => 't2', 'touchpoint_type' => 'qr', 'star_rating' => 4, 'google_redirect_completed' => true]);

        // Mock 1 raw scan
        ReviewSession::create(['branch_id' => $branch->id, 'session_token' => 't3', 'touchpoint_type' => 'qr']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Total Reviews');
        $response->assertSee('2'); // Total completed reviews
        $response->assertSee('4.5'); // Avg rating
    }

    public function test_can_access_dashboard_submodules(): void
    {
        $user = User::factory()->create(['primary_role' => 'business_owner']);
        $business = Business::create([
            'owner_user_id' => $user->id,
            'name' => 'Test Business',
            'category' => 'Retail',
            'slug' => 'test-retail',
            'onboarding_completed' => true,
        ]);
        $user->update(['current_business_id' => $business->id]);

        $this->actingAs($user)->get('/business')->assertStatus(200);
        $this->actingAs($user)->get('/qr')->assertStatus(200);
        $this->actingAs($user)->get('/feedback')->assertStatus(200);
        $this->actingAs($user)->get('/analytics')->assertStatus(200);
    }
}
