<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['merchant_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
