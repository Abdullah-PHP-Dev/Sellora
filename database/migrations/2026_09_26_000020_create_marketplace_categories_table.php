<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marketplace_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('external_category_id', 200);

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('marketplace_categories')
                ->nullOnDelete();

            $table->string('name');
            $table->string('path')->nullable();

            $table->boolean('is_leaf')->default(false);
            $table->boolean('is_active')->default(true);

            $table->json('metadata')->nullable();

            $table->timestamps();

            // Marketplace + external category must be unique.
            $table->unique(
                ['marketplace_id', 'external_category_id'],
                'mc_marketplace_ext_cat_unique'
            );

            // Efficient parent/category lookup.
            $table->index(
                ['marketplace_id', 'parent_id'],
                'mc_marketplace_parent_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_categories');
    }
};