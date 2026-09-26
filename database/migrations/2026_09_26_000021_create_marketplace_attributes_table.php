<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marketplace_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('external_attribute_id', 200);

            $table->string('name');

            $table->string('code', 150)
                ->nullable();

            $table->string('data_type', 30)
                ->default('string');

            $table->boolean('is_required')
                ->default(false);

            $table->boolean('is_variant')
                ->default(false);

            $table->json('validation_rules')
                ->nullable();

            $table->json('metadata')
                ->nullable();

            $table->timestamps();

            // One external attribute can exist only once per marketplace.
            $table->unique(
                ['marketplace_id', 'external_attribute_id'],
                'ma_marketplace_ext_attr_unique'
            );

            // Efficient marketplace + attribute code lookup.
            $table->index(
                ['marketplace_id', 'code'],
                'ma_marketplace_code_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_attributes');
    }
};