<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->string('website_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->jsonb('capabilities')->nullable();
            $table->jsonb('configuration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplaces');
    }
};
