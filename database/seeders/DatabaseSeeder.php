<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            IndustrySeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@zeprank.com',
            'primary_role' => 'admin',
        ]);

        $owner = User::factory()->create([
            'name' => 'Business Owner',
            'email' => 'owner@zeprank.com',
            'primary_role' => 'business_owner',
        ]);

        $biz = \App\Models\Business::create([
            'owner_user_id' => $owner->id,
            'name' => 'Verif Coffee',
            'category' => 'Cafe',
            'slug' => 'verif-coffee',
            'city' => 'Mumbai',
            'onboarding_completed' => true,
        ]);

        $owner->update(['current_business_id' => $biz->id]);

        \App\Models\Branch::create([
            'business_id' => $biz->id,
            'name' => 'Main Street',
            'slug' => 'main-street',
            'google_review_url' => 'https://maps.google.com',
        ]);
    }
}
