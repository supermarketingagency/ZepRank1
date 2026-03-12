<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('private_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('review_session_id')->constrained('review_sessions');
            $table->text('encrypted_content');
            $table->tinyInteger('star_rating');
            $table->decimal('sentiment_score', 5, 2)->nullable();
            $table->enum('sentiment_label', ['positive','neutral','negative'])->nullable();
            $table->enum('status', ['new','in_review','resolved','escalated'])->default('new');
            $table->foreignId('assignee_id')->nullable()->constrained('users');
            $table->boolean('is_read')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->index(['branch_id', 'status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('private_feedbacks');
    }
};
