<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('company_name');
            $table->string('custom_domain')->nullable()->unique();
            $table->string('brand_name')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('primary_color')->default('#4F46E5');
            $table->string('secondary_color')->default('#7C3AED');
            $table->enum('status', ['active','suspended','pending'])->default('pending');
            $table->enum('wholesale_plan', ['starter','growth','pro','enterprise'])->default('starter');
            $table->decimal('wholesale_monthly_fee', 10, 2)->default(0);
            $table->json('feature_overrides')->nullable();
            $table->text('custom_css')->nullable();
            $table->text('smtp_config_encrypted')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resellers');
    }
};
