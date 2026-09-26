<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_connection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_attribute_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_attribute_id', 200)->nullable();
            $table->string('external_attribute_name')->nullable();
            $table->jsonb('mapping_rules')->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->timestamps();
            $table->unique(['marketplace_connection_id', 'attribute_id'], 'attr_map_conn_attr_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_mappings');
    }
};
