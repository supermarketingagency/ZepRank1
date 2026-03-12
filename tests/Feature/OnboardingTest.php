<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Business;
use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingTest extends TestCase
{
    use RefreshDatabase;

    public function test_business_owner_is_redirected_to_onboarding(): void
    {
        $user = User::factory()->create([
            'primary_role' => 'business_owner',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/onboarding');
    }

    public function test_business_owner_can_complete_step1(): void
    {
        $user = User::factory()->create([
            'primary_role' => 'business_owner',
        ]);

        $response = $this->actingAs($user)->post('/onboarding/step1', [
            'name' => 'Test Business',
            'category' => 'Restaurant',
            'city' => 'Mumbai',
        ]);

        $response->assertRedirect('/onboarding');
        $this->assertDatabaseHas('businesses', [
            'name' => 'Test Business',
            'owner_user_id' => $user->id,
            'onboarding_step' => 2,
        ]);

        $user->refresh();
        $this->assertEquals(Business::first()->id, $user->current_business_id);
    }

    public function test_business_owner_can_complete_step2(): void
    {
        $user = User::factory()->create([
            'primary_role' => 'business_owner',
        ]);

        $business = Business::create([
            'owner_user_id' => $user->id,
            'name' => 'Test Business',
            'category' => 'Restaurant',
            'slug' => 'test-business',
            'onboarding_step' => 2,
        ]);

        $user->update(['current_business_id' => $business->id]);

        $response = $this->actingAs($user)->post('/onboarding/step2', [
            'branch_name' => 'Main Branch',
            'google_review_url' => 'https://google.com/review',
        ]);

        $response->assertRedirect('/onboarding');
        $this->assertDatabaseHas('branches', [
            'name' => 'Main Branch',
            'google_review_url' => 'https://google.com/review',
            'business_id' => $business->id,
        ]);

        $this->assertEquals(3, $business->fresh()->onboarding_step);
    }

    public function test_business_owner_can_complete_full_onboarding(): void
    {
        $user = User::factory()->create([
            'primary_role' => 'business_owner',
        ]);

        $business = Business::create([
            'owner_user_id' => $user->id,
            'name' => 'Test Business',
            'category' => 'Restaurant',
            'slug' => 'test-business',
            'onboarding_step' => 3,
        ]);

        $user->update(['current_business_id' => $business->id]);
        $branch = Branch::create(['business_id' => $business->id, 'name' => 'Main', 'slug' => 'main']);

        $this->actingAs($user)->post('/onboarding/step3', ['threshold' => 5])->assertRedirect('/onboarding');
        $this->assertEquals(4, $business->fresh()->onboarding_step);
        $this->assertEquals(5, $branch->fresh()->negative_review_threshold);

        $this->actingAs($user)->post('/onboarding/step4', [
            'welcome_message' => 'Test Welcome',
            'primary_color' => '#123456',
        ])->assertRedirect('/onboarding');
        $this->assertEquals(5, $business->fresh()->onboarding_step);

        $this->actingAs($user)->post('/onboarding/step5')->assertRedirect('/dashboard');
        $this->assertTrue($business->fresh()->onboarding_completed);
    }
}
