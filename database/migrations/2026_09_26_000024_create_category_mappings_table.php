<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_connection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sellora_category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('marketplace_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_category_id', 200)->nullable();
            $table->string('external_category_name')->nullable();
            $table->jsonb('mapping_data')->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->timestamps();
            $table->unique(['marketplace_connection_id', 'sellora_category_id'], 'cat_map_conn_cat_unique');
            $table->index(['merchant_id', 'marketplace_connection_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_mappings');
    }
};
