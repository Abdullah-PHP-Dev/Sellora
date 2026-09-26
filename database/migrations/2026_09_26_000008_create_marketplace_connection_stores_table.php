<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_connection_stores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marketplace_connection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('store_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            // Explicit short name to stay within MySQL's 64-character limit.
            $table->unique(
                ['marketplace_connection_id', 'store_id'],
                'mc_stores_conn_store_unique'
            );

            $table->index(
                ['store_id', 'marketplace_connection_id'],
                'mc_stores_store_conn_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_connection_stores');
    }
};