<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->uuid('event_id')->unique();
            $table->string('event_type', 200);
            $table->string('event_version', 20)->default('1.0');
            $table->string('source', 100);
            $table->string('aggregate_type', 100);
            $table->unsignedBigInteger('aggregate_id');
            $table->uuid('correlation_id')->nullable()->index();
            $table->uuid('causation_id')->nullable()->index();
            $table->jsonb('payload');
            $table->string('status', 30)->default('pending')->index();
            $table->timestamp('occurred_at');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->index(['aggregate_type', 'aggregate_id']);
            $table->index(['merchant_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_events');
    }
};
