<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_location_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();
            $table->string('movement_type', 50);
            $table->bigInteger('quantity');
            $table->bigInteger('quantity_before');
            $table->bigInteger('quantity_after');
            $table->string('source', 50)->default('system');
            $table->string('reference_type', 100)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reason')->nullable();
            $table->string('external_reference')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['inventory_location_id', 'product_variant_id', 'created_at'], 'inv_mov_loc_var_created_idx');
            $table->index(['reference_type', 'reference_id']);
            $table->index(['merchant_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
