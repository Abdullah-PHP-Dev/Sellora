<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('marketplace_listing_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_line_item_id', 200)->nullable();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('unit_price', 19, 4)->default(0);
            $table->decimal('discount', 19, 4)->default(0);
            $table->decimal('tax', 19, 4)->default(0);
            $table->decimal('total', 19, 4)->default(0);
            $table->char('currency_code', 3)->default('SAR');
            $table->integer('fulfilled_quantity')->default(0);
            $table->integer('cancelled_quantity')->default(0);
            $table->integer('returned_quantity')->default(0);
            $table->jsonb('product_snapshot')->nullable();
            $table->jsonb('marketplace_data')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'product_variant_id']);
            $table->index(['sku']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
