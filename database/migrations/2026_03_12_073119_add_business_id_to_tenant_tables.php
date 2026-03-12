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
        Schema::table('review_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('review_sessions', 'business_id')) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            }
        });

        Schema::table('private_feedbacks', function (Blueprint $table) {
            if (!Schema::hasColumn('private_feedbacks', 'business_id')) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            }
        });

        Schema::table('ai_review_drafts', function (Blueprint $table) {
            if (!Schema::hasColumn('ai_review_drafts', 'business_id')) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('cascade');
            }
        });

        // Populate business_id from related tables using subqueries for cross-database compatibility (MySQL/SQLite)
        DB::statement("UPDATE review_sessions SET business_id = (SELECT business_id FROM branches WHERE branches.id = review_sessions.branch_id)");
        DB::statement("UPDATE private_feedbacks SET business_id = (SELECT business_id FROM branches WHERE branches.id = private_feedbacks.branch_id)");
        DB::statement("UPDATE ai_review_drafts SET business_id = (SELECT business_id FROM review_sessions WHERE review_sessions.id = ai_review_drafts.review_session_id)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_sessions', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
        });

        Schema::table('private_feedbacks', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
        });

        Schema::table('ai_review_drafts', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
        });
    }
};
