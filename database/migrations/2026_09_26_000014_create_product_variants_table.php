<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->string('sku');
            $table->string('name');
            $table->decimal('price', 19, 4)->default(0);
            $table->decimal('cost_price', 19, 4)->nullable();
            $table->decimal('compare_at_price', 19, 4)->nullable();
            $table->char('currency_code', 3)->default('SAR');
            $table->decimal('weight', 12, 4)->nullable();
            $table->string('weight_unit', 20)->default('kg');
            $table->decimal('length', 12, 3)->nullable();
            $table->decimal('width', 12, 3)->nullable();
            $table->decimal('height', 12, 3)->nullable();
            $table->string('dimension_unit', 20)->default('cm');
            $table->string('status', 30)->default('active')->index();
            $table->boolean('is_default')->default(false);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['merchant_id', 'sku']);
            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
