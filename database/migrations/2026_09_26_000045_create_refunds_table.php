<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('return_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_payment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_refund_id', 200)->nullable();
            $table->decimal('amount', 19, 4);
            $table->char('currency_code', 3);
            $table->string('status', 30)->default('pending')->index();
            $table->string('reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->unique(['order_id', 'external_refund_id'], 'refund_order_ext_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
