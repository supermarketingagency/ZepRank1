<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Sends a WhatsApp review request using Meta Business API.
     */
    public function sendReviewRequest(string $phone, string $businessName, string $reviewUrl)
    {
        $token = config('services.whatsapp.token');
        $phoneId = config('services.whatsapp.phone_id');

        if (!$token || !$phoneId) {
            Log::warning("WhatsApp credentials missing. Simulating send to $phone.");
            return true;
        }

        try {
            $response = Http::withToken($token)->post("https://graph.facebook.com/v18.0/$phoneId/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => [
                    'name' => 'review_request',
                    'language' => ['code' => 'en'],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => $businessName],
                                ['type' => 'text', 'text' => $reviewUrl],
                            ]
                        ]
                    ]
                ]
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("WhatsApp send failed: " . $e->getMessage());
            return false;
        }
    }
}
