<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('status', 30)->default('active')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_until')->nullable();
            $table->jsonb('settings')->nullable();
            $table->timestamps();
            $table->unique(['store_id', 'product_id']);
            $table->index(['merchant_id', 'store_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_products');
    }
};
