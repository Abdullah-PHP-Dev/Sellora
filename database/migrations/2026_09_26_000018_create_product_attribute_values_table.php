<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('attribute_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('attribute_option_id')
                ->nullable()
                ->constrained('attribute_options')
                ->nullOnDelete();

            $table->text('value_string')->nullable();
            $table->decimal('value_number', 19, 6)->nullable();
            $table->boolean('value_boolean')->nullable();
            $table->jsonb('value_json')->nullable();

            $table->timestamps();

            // Composite indexes with explicit short names
            $table->index(
                ['merchant_id', 'product_id', 'attribute_id'],
                'pav_merchant_product_attr_idx'
            );

            $table->index(
                ['product_variant_id', 'attribute_id'],
                'pav_variant_attr_idx'
            );

            $table->index(
                ['attribute_id', 'attribute_option_id'],
                'pav_attr_option_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};