<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_marketplace_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('marketplace_connection_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('external_customer_id', 200);

            $table->string('external_customer_name')
                ->nullable();

            $table->string('external_email')
                ->nullable();

            $table->string('external_phone', 50)
                ->nullable();

            $table->json('metadata')
                ->nullable();

            $table->timestamp('last_synced_at')
                ->nullable();

            $table->timestamps();

            /*
             * One external customer can only be mapped once
             * for a specific marketplace connection.
             */
            $table->unique(
                ['marketplace_connection_id', 'external_customer_id'],
                'cust_mkt_ext_unique'
            );

            /*
             * Useful for finding the marketplace account
             * belonging to a specific Sellora customer.
             */
            $table->index(
                ['customer_id', 'marketplace_connection_id'],
                'cma_customer_connection_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_marketplace_accounts');
    }
};