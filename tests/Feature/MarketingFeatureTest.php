<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Business;
use App\Models\Festival;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MarketingFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_queue_whatsapp_request()
    {
        Bus::fake();
        $user = User::factory()->create(['primary_role' => 'business_owner']);
        $biz = Business::create(['owner_user_id' => $user->id, 'name' => 'Test Biz', 'slug' => 'test-biz', 'category' => 'Retail']);
        $branch = Branch::create(['business_id' => $biz->id, 'name' => 'Main', 'slug' => 'main']);
        $user->update(['current_business_id' => $biz->id]);

        $response = $this->actingAs($user)->post(route('dashboard.marketing.send'), [
            'type' => 'whatsapp',
            'recipient' => '+919876543210',
            'branch_id' => $branch->id
        ]);

        $response->assertStatus(302);
        Bus::assertDispatched(\App\Jobs\SendReviewRequestJob::class);
    }

    public function test_can_generate_festival_poster()
    {
        Storage::fake('public');
        $user = User::factory()->create(['primary_role' => 'business_owner']);
        $biz = Business::create(['owner_user_id' => $user->id, 'name' => 'Test Biz', 'slug' => 'test-biz', 'category' => 'Retail']);
        $branch = Branch::create(['business_id' => $biz->id, 'name' => 'Main', 'slug' => 'main']);
        $user->update(['current_business_id' => $biz->id]);

        $festival = Festival::create(['name' => 'Diwali', 'slug' => 'diwali', 'festival_date' => now()->addDays(5)]);

        $response = $this->actingAs($user)->post(route('dashboard.creative.generate', $festival->id));

        $response->assertStatus(302);
        $this->assertDatabaseHas('branded_posters', [
            'festival_id' => $festival->id,
            'business_id' => $biz->id
        ]);
    }
}
