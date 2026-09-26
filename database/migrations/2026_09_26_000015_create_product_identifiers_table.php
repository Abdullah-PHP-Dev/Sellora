<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_identifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30);
            $table->string('value', 150);
            $table->boolean('is_primary')->default(false);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->unique(['merchant_id', 'type', 'value']);
            $table->index(['product_variant_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_identifiers');
    }
};
