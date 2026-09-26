<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_balances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('inventory_location_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->bigInteger('on_hand')
                ->default(0);

            $table->bigInteger('reserved')
                ->default(0);

            $table->bigInteger('incoming')
                ->default(0);

            $table->bigInteger('damaged')
                ->default(0);

            $table->bigInteger('safety_stock')
                ->default(0);

            $table->bigInteger('available')
                ->storedAs('on_hand - reserved - safety_stock - damaged');

            $table->bigInteger('version')
                ->default(1);

            $table->timestamp('last_calculated_at')
                ->nullable();

            $table->timestamps();

            /*
             * One balance record per inventory location
             * and product variant.
             */
            $table->unique(
                ['inventory_location_id', 'product_variant_id'],
                'ib_location_variant_unique'
            );

            /*
             * Efficient merchant-level inventory queries.
             */
            $table->index(
                ['merchant_id', 'product_variant_id'],
                'ib_merchant_variant_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_balances');
    }
};