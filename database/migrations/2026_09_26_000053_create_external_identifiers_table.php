<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_identifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_connection_id')->constrained()->cascadeOnDelete();
            $table->string('entity_type', 100);
            $table->unsignedBigInteger('entity_id');
            $table->string('identifier_type', 50);
            $table->string('external_id', 300);
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->unique(['marketplace_connection_id', 'identifier_type', 'external_id'], 'ext_id_conn_type_value_unique');
            $table->index(['entity_type', 'entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_identifiers');
    }
};
