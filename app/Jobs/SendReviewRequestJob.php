<?php

namespace App\Jobs;

use App\Services\EmailService;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReviewRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsapp, EmailService $email)
    {
        $type = $this->data['type']; // 'whatsapp' or 'email'
        $recipient = $this->data['recipient'];
        $businessName = $this->data['business_name'];
        $reviewUrl = $this->data['review_url'];

        Log::info("Processing $type review request for $recipient");

        if ($type === 'whatsapp') {
            $whatsapp->sendReviewRequest($recipient, $businessName, $reviewUrl);
        } else {
            $email->sendReviewRequest($recipient, $businessName, $reviewUrl);
        }
    }
}
