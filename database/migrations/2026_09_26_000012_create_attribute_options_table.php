<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->string('value');
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->string('status', 30)->default('active');
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->unique(['attribute_id', 'value']);
            $table->index(['attribute_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_options');
    }
};
