<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('google_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('reviewer_name');
            $table->string('reviewer_photo_url')->nullable();
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->text('reply_suggestion')->nullable();
            $table->text('actual_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->string('google_review_id')->unique()->nullable();
            $table->timestamp('review_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_reviews');
    }
};
