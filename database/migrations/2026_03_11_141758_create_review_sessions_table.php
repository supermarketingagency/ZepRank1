<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches');
            $table->string('session_token', 64)->unique();
            $table->enum('touchpoint_type', ['qr','nfc','link','whatsapp','api']);
            $table->tinyInteger('star_rating')->nullable();
            $table->enum('route', ['google','private_feedback'])->nullable();
            $table->boolean('mcq_completed')->default(false);
            $table->tinyInteger('ai_draft_selected')->nullable();
            $table->boolean('copy_confirmed')->default(false);
            $table->boolean('google_redirect_completed')->default(false);
            $table->string('ai_provider_used')->nullable();
            $table->string('ai_model_used')->nullable();
            $table->string('device_type')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            $table->index(['branch_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_sessions');
    }
};
