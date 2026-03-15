<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Sends an Email review request.
     */
    public function sendReviewRequest(string $email, string $businessName, string $reviewUrl)
    {
        try {
            Mail::send([], [], function ($message) use ($email, $businessName, $reviewUrl) {
                $message->to($email)
                    ->subject("Your experience at $businessName")
                    ->html("
                        <div style='font-family: sans-serif; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
                            <h2 style='color: #1a73e8;'>We'd love your feedback!</h2>
                            <p>Hi there, thank you for visiting <strong>$businessName</strong>.</p>
                            <p>Could you please take 30 seconds to share your experience with us?</p>
                            <a href='$reviewUrl' style='display: inline-block; padding: 10px 20px; background-color: #1a73e8; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;'>Rate Us Now</a>
                            <p style='margin-top: 20px; font-size: 12px; color: #777;'>If you have any issues, please reply to this email.</p>
                        </div>
                    ");
            });

            return true;
        } catch (\Exception $e) {
            Log::error("Email send failed: " . $e->getMessage());
            return false;
        }
    }
}
