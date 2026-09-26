<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('type', 50);
            $table->string('code', 100)->nullable();
            $table->string('description')->nullable();
            $table->decimal('amount', 19, 4);
            $table->char('currency_code', 3);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->index(['order_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_adjustments');
    }
};
