<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method', 50);
            $table->string('external_payment_id', 200)->nullable();
            $table->decimal('amount', 19, 4);
            $table->char('currency_code', 3);
            $table->string('status', 30)->default('pending')->index();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->unique(['order_id', 'external_payment_id'], 'ord_pay_ext_unique');
            $table->index(['merchant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
