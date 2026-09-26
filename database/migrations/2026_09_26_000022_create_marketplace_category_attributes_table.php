<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_category_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marketplace_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_attribute_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_variant')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->integer('sort_order')->default(0);
            $table->jsonb('validation_rules')->nullable();
            $table->timestamps();
            $table->unique(['marketplace_category_id', 'marketplace_attribute_id'], 'mkt_cat_attr_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_category_attributes');
    }
};
