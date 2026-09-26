<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('external_shipment_id', 200)->nullable();
            $table->string('status', 30)->default('pending')->index();
            $table->string('carrier', 100)->nullable();
            $table->string('service', 100)->nullable();
            $table->string('tracking_number', 150)->nullable();
            $table->text('tracking_url')->nullable();
            $table->decimal('shipping_cost', 19, 4)->nullable();
            $table->char('currency_code', 3)->default('SAR');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('estimated_delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'status']);
            $table->index(['tracking_number']);
            $table->unique(['order_id', 'external_shipment_id'], 'ship_order_ext_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
