<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('provider', 100);
            $table->foreignId('merchant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('marketplace_connection_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('marketplace_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event_type', 200);
            $table->string('external_event_id', 300)->nullable();
            $table->string('idempotency_key', 300);
            $table->text('signature')->nullable();
            $table->jsonb('headers')->nullable();
            $table->jsonb('payload');
            $table->string('status', 30)->default('pending')->index();
            $table->integer('attempts')->default(0);
            $table->timestamp('received_at')->useCurrent();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('next_retry_at')->nullable();
            $table->string('error_code', 100)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            $table->unique(['provider', 'idempotency_key'], 'webhook_provider_idempotency_unique');
            $table->index(['marketplace_connection_id', 'received_at']);
            $table->index(['provider', 'external_event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_events');
    }
};
