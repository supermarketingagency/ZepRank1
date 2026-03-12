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
        Schema::table('branches', function (Blueprint $table) {
            if (!Schema::hasColumn('branches', 'review_filter_enabled')) {
                $table->boolean('review_filter_enabled')->default(true);
            }
            if (!Schema::hasColumn('branches', 'interface_language')) {
                $table->string('interface_language')->default('en');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn(['review_filter_enabled', 'interface_language']);
        });
    }
};
