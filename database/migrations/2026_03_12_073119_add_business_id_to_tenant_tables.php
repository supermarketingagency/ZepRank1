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

        // Populate business_id from related tables
        // ReviewSession belongs to Branch, which belongs to Business
        DB::statement("UPDATE review_sessions rs JOIN branches b ON rs.branch_id = b.id SET rs.business_id = b.business_id");
        DB::statement("UPDATE private_feedbacks pf JOIN branches b ON pf.branch_id = b.id SET pf.business_id = b.business_id");
        DB::statement("UPDATE ai_review_drafts ard JOIN review_sessions rs ON ard.review_session_id = rs.id SET ard.business_id = rs.business_id");
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
