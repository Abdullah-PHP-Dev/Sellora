<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_location_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();
            $table->string('reference_type', 100);
            $table->unsignedBigInteger('reference_id');
            $table->bigInteger('quantity');
            $table->bigInteger('fulfilled_quantity')->default(0);
            $table->string('status', 30)->default('active')->index();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->string('release_reason')->nullable();
            $table->timestamps();
            $table->index(['reference_type', 'reference_id']);
            $table->index(['product_variant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_reservations');
    }
};
