<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'monthly_price' => 199,
                'annual_price' => 1499,
                'ai_token_limit' => 10000,
                'branch_limit' => 2,
                'team_limit' => 3,
                'features' => ['qr_code', 'dashboard', 'review_tracking', 'negative_bypass', 'groq'],
            ],
            [
                'name' => 'Growth',
                'monthly_price' => 299,
                'annual_price' => 2499,
                'ai_token_limit' => 20000,
                'branch_limit' => 2,
                'team_limit' => 10,
                'features' => ['qr_code', 'dashboard', 'review_tracking', 'negative_bypass', 'custom_links', 'advanced_analytics', 'openai', 'gemini'],
            ],
            [
                'name' => 'Pro',
                'monthly_price' => 399,
                'annual_price' => 2999,
                'ai_token_limit' => 50000,
                'branch_limit' => 4,
                'team_limit' => 10,
                'features' => ['qr_code', 'dashboard', 'review_tracking', 'negative_bypass', 'custom_links', 'advanced_analytics', 'nfc_card', 'standee', 'whatsapp_integration', 'all_ai'],
            ],
            [
                'name' => 'Enterprise',
                'monthly_price' => null,
                'annual_price' => null,
                'ai_token_limit' => -1,
                'branch_limit' => -1,
                'team_limit' => -1,
                'features' => ['all_features', 'white_label', 'api_access', 'priority_support'],
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
