<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResellerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reseller_can_access_dashboard(): void
    {
        $user = User::factory()->create(['primary_role' => 'reseller']);

        $response = $this->actingAs($user)->get('/reseller/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Reseller Dashboard');
    }

    public function test_non_reseller_cannot_access_reseller_dashboard(): void
    {
        $user = User::factory()->create(['primary_role' => 'business_owner']);

        $response = $this->actingAs($user)->get('/reseller/dashboard');

        $response->assertStatus(403);
    }
}
