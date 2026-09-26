<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('marketplace_connection_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('marketplace_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_order_id', 200)->nullable();
            $table->string('external_order_number')->nullable();
            $table->string('order_number');
            $table->string('status', 30)->default('pending')->index();
            $table->string('financial_status', 30)->default('pending')->index();
            $table->string('fulfillment_status', 30)->default('unfulfilled')->index();
            $table->char('currency_code', 3)->default('SAR');
            $table->decimal('subtotal', 19, 4)->default(0);
            $table->decimal('discount_total', 19, 4)->default(0);
            $table->decimal('tax_total', 19, 4)->default(0);
            $table->decimal('shipping_total', 19, 4)->default(0);
            $table->decimal('total', 19, 4)->default(0);
            $table->timestamp('ordered_at');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->unsignedBigInteger('billing_address_id')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->jsonb('marketplace_data')->nullable();
            $table->timestamps();
            $table->unique(['merchant_id', 'order_number']);
            $table->unique(['marketplace_connection_id', 'external_order_id'], 'ord_conn_ext_id_unique');
            $table->index(['merchant_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
