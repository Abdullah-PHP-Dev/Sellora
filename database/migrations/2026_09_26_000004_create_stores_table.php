<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website_url')->nullable();
            $table->char('country_code', 2)->default('SA');
            $table->char('currency_code', 3)->default('SAR');
            $table->string('timezone', 100)->default('Asia/Riyadh');
            $table->string('default_locale', 10)->default('en');
            $table->string('status', 30)->default('active')->index();
            $table->jsonb('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['merchant_id', 'slug']);
            $table->unique(['merchant_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
