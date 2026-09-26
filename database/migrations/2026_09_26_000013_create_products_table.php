<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('master_sku');
            $table->string('product_type', 50)->default('simple');
            $table->string('name');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('status', 30)->default('draft')->index();
            $table->string('tax_code', 100)->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('manufacturer_part_number')->nullable();
            $table->decimal('default_price', 19, 4)->default(0);
            $table->decimal('cost_price', 19, 4)->nullable();
            $table->char('currency_code', 3)->default('SAR');
            $table->decimal('weight', 12, 4)->nullable();
            $table->string('weight_unit', 20)->default('kg');
            $table->decimal('length', 12, 3)->nullable();
            $table->decimal('width', 12, 3)->nullable();
            $table->decimal('height', 12, 3)->nullable();
            $table->string('dimension_unit', 20)->default('cm');
            $table->boolean('track_inventory')->default(true);
            $table->boolean('requires_shipping')->default(true);
            $table->boolean('is_virtual')->default(false);
            $table->jsonb('metadata')->nullable();
            $table->jsonb('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['merchant_id', 'master_sku']);
            $table->unique(['merchant_id', 'slug']);
            $table->index(['merchant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
