<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Business;
use App\Models\Branch;
use App\Models\ReviewSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['primary_role' => 'business_owner']);
        $this->business = Business::create([
            'owner_user_id' => $this->user->id,
            'name' => 'City Cafe',
            'category' => 'Restaurant',
            'slug' => 'city-cafe',
        ]);
        $this->branch = Branch::create([
            'business_id' => $this->business->id,
            'name' => 'Main Branch',
            'slug' => 'main-branch',
            'google_review_url' => 'https://google.com/review',
            'negative_review_threshold' => 4,
        ]);
    }

    public function test_can_access_review_flow(): void
    {
        $response = $this->get('/r/main-branch');

        $response->assertStatus(200);
        $response->assertSee('City Cafe');
        $this->assertDatabaseHas('review_sessions', ['branch_id' => $this->branch->id]);
    }

    public function test_positive_rating_routes_to_reviews(): void
    {
        $session = ReviewSession::create(['branch_id' => $this->branch->id, 'session_token' => 'test_token', 'touchpoint_type' => 'link']);

        $response = $this->post('/r/main-branch/rate', [
            'rating' => 5,
            'session_token' => 'test_token',
        ]);

        $response->assertRedirect('/r/main-branch/reviews?token=test_token');
        $this->assertEquals(5, $session->fresh()->star_rating);
        $this->assertEquals('google', $session->fresh()->route);
    }

    public function test_negative_rating_routes_to_feedback(): void
    {
        $session = ReviewSession::create(['branch_id' => $this->branch->id, 'session_token' => 'test_token', 'touchpoint_type' => 'link']);

        $response = $this->post('/r/main-branch/rate', [
            'rating' => 3,
            'session_token' => 'test_token',
        ]);

        $response->assertRedirect('/r/main-branch/feedback?token=test_token');
        $this->assertEquals(3, $session->fresh()->star_rating);
        $this->assertEquals('private_feedback', $session->fresh()->route);
    }
}
