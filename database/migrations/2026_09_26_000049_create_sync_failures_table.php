<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_failures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sync_job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_connection_id')->constrained()->cascadeOnDelete();
            $table->string('entity_type', 100);
            $table->unsignedBigInteger('entity_id');
            $table->string('operation', 100);
            $table->integer('attempt_number')->default(1);
            $table->string('error_code', 100)->nullable();
            $table->text('error_message');
            $table->jsonb('request_payload')->nullable();
            $table->jsonb('response_payload')->nullable();
            $table->boolean('retryable')->default(true);
            $table->timestamp('failed_at')->useCurrent();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('resolution_note')->nullable();
            $table->timestamps();
            $table->index(['sync_job_id', 'failed_at']);
            $table->index(['merchant_id', 'resolved_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_failures');
    }
};
