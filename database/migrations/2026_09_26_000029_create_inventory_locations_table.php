<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code', 50);
            $table->string('location_type', 50)->default('warehouse');
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 30)->nullable();
            $table->char('country_code', 2)->default('SA');
            $table->string('status', 30)->default('active')->index();
            $table->jsonb('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['merchant_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_locations');
    }
};
