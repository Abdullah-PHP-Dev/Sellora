<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained()->restrictOnDelete();
            $table->integer('quantity');
            $table->string('reason')->nullable();
            $table->string('condition', 50)->nullable();
            $table->decimal('refund_amount', 19, 4)->default(0);
            $table->char('currency_code', 3)->default('SAR');
            $table->timestamps();
            $table->index(['return_id', 'order_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
