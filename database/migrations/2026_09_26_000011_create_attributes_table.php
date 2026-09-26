<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 100);
            $table->string('data_type', 30)->default('string');
            $table->string('unit', 30)->nullable();
            $table->boolean('is_variant_attribute')->default(false);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->jsonb('validation_rules')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->index(['merchant_id', 'code']);
            $table->index(['merchant_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
