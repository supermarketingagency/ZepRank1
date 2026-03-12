<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('address')->nullable();
            $table->string('google_review_url')->nullable();
            $table->tinyInteger('negative_review_threshold')->default(4);
            $table->boolean('review_link_active')->default(true);
            $table->string('ai_provider_override')->nullable();
            $table->string('ai_model_override')->nullable();
            $table->text('ai_api_key_encrypted')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
