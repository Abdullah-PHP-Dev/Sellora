<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_syncs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('marketplace_connection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('marketplace_listing_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('inventory_location_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->bigInteger('requested_quantity');

            $table->bigInteger('sent_quantity')
                ->nullable();

            $table->string('status', 30)
                ->default('pending');

            $table->integer('attempts')
                ->default(0);

            $table->timestamp('last_attempt_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->json('external_response')
                ->nullable();

            $table->text('error_message')
                ->nullable();

            $table->timestamps();

            /*
             * Indexes
             * Explicit names prevent MySQL's 64-character
             * identifier limit from being exceeded.
             */

            $table->index(
                ['marketplace_connection_id', 'product_variant_id', 'status'],
                'is_connection_variant_status_idx'
            );

            $table->index(
                ['status'],
                'is_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_syncs');
    }
};