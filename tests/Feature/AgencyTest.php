<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_agency_can_access_dashboard(): void
    {
        $user = User::factory()->create(['primary_role' => 'marketer']);

        $response = $this->actingAs($user)->get('/agency/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Agency Dashboard');
    }

    public function test_regular_user_cannot_access_agency_dashboard(): void
    {
        $user = User::factory()->create(['primary_role' => 'business_owner']);

        $response = $this->actingAs($user)->get('/agency/dashboard');

        $response->assertStatus(403);
    }
}
