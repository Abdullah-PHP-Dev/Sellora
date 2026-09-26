<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('external_account_id')->nullable();
            $table->string('external_account_name')->nullable();
            $table->string('auth_type', 50)->default('oauth2');
            $table->string('status', 30)->default('active')->index();
            $table->timestamp('access_token_expires_at')->nullable();
            $table->timestamp('refresh_token_expires_at')->nullable();
            $table->timestamp('last_validated_at')->nullable();
            $table->timestamp('last_successful_sync_at')->nullable();
            $table->timestamp('last_products_sync_at')->nullable();
            $table->timestamp('last_inventory_sync_at')->nullable();
            $table->timestamp('last_orders_sync_at')->nullable();
            $table->timestamp('last_customers_sync_at')->nullable();
            $table->timestamp('last_error_at')->nullable();
            $table->text('last_error_message')->nullable();
            $table->jsonb('settings')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('disconnected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['merchant_id', 'marketplace_id']);
            $table->index(['merchant_id', 'status']);
            $table->unique(['merchant_id', 'marketplace_id', 'external_account_id'], 'mkt_conn_ext_account_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_connections');
    }
};
