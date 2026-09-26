<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_attribute_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('marketplace_attribute_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('external_option_id', 200)
                ->nullable();

            $table->string('value');

            $table->string('label');

            $table->integer('sort_order')
                ->default(0);

            $table->json('metadata')
                ->nullable();

            $table->timestamps();

            // An option value must be unique within its marketplace attribute.
            $table->unique(
                ['marketplace_attribute_id', 'value'],
                'mao_attribute_value_unique'
            );

            // Efficient external option lookup/synchronization.
            $table->index(
                ['marketplace_attribute_id', 'external_option_id'],
                'mao_attribute_ext_opt_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_attribute_options');
    }
};