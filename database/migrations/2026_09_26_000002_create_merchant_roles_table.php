<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->jsonb('permissions')->nullable();
            $table->timestamps();
            $table->unique(['merchant_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_roles');
    }
};
