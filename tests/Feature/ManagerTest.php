<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_gmb_manager_can_access_dashboard(): void
    {
        $user = User::factory()->create(['primary_role' => 'gmb_manager']);

        $response = $this->actingAs($user)->get('/manager/dashboard');

        $response->assertStatus(200);
        $response->assertSee('GMB Manager Dashboard');
    }

    public function test_regular_user_cannot_access_manager_dashboard(): void
    {
        $user = User::factory()->create(['primary_role' => 'business_owner']);

        $response = $this->actingAs($user)->get('/manager/dashboard');

        $response->assertStatus(403);
    }
}
