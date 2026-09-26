<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('billing_address_id')->references('id')->on('order_addresses')->nullOnDelete();
            $table->foreign('shipping_address_id')->references('id')->on('order_addresses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['billing_address_id']);
            $table->dropForeign(['shipping_address_id']);
        });
    }
};
