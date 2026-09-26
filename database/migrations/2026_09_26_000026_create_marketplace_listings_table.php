<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_listings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('store_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('marketplace_connection_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('external_listing_id', 200)
                ->nullable();

            $table->string('external_product_id', 200)
                ->nullable();

            $table->string('external_sku', 200)
                ->nullable();

            $table->string('title');

            $table->text('description')
                ->nullable();

            $table->string('listing_status', 30)
                ->default('draft');

            $table->string('publish_status', 30)
                ->default('pending');

            $table->decimal('price', 19, 4)
                ->default(0);

            $table->char('currency_code', 3)
                ->default('SAR');

            $table->bigInteger('quantity')
                ->default(0);

            $table->foreignId('marketplace_category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamp('last_synced_at')
                ->nullable();

            $table->timestamp('last_published_at')
                ->nullable();

            $table->string('sync_status', 30)
                ->default('pending');

            $table->text('sync_error')
                ->nullable();

            $table->json('marketplace_data')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            /*
             * Indexes
             * Explicit names are used to avoid MySQL's 64-character
             * identifier limitation.
             */

            $table->index(
                ['marketplace_connection_id', 'listing_status'],
                'ml_connection_status_idx'
            );

            $table->index(
                ['merchant_id', 'product_variant_id'],
                'ml_merchant_variant_idx'
            );

            $table->index(
                ['listing_status'],
                'ml_listing_status_idx'
            );

            $table->index(
                ['publish_status'],
                'ml_publish_status_idx'
            );

            $table->index(
                ['sync_status'],
                'ml_sync_status_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_listings');
    }
};