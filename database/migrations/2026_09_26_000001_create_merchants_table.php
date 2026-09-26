<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('slug')->unique();
            $table->string('legal_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->char('country_code', 2)->default('SA');
            $table->char('currency_code', 3)->default('SAR');
            $table->string('timezone', 100)->default('Asia/Riyadh');
            $table->string('default_locale', 10)->default('en');
            $table->string('type', 30)->default('business');
            $table->string('status', 30)->default('active')->index();
            $table->jsonb('settings')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
