<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_connection_id')->nullable()->constrained()->nullOnDelete();
            $table->string('job_type', 100);
            $table->string('entity_type', 100)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->integer('priority')->default(5);
            $table->string('status', 30)->default('pending')->index();
            $table->integer('attempts')->default(0);
            $table->integer('max_attempts')->default(3);
            $table->jsonb('payload')->nullable();
            $table->timestamp('scheduled_at')->useCurrent();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('next_attempt_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->string('locked_by')->nullable();
            $table->string('error_code', 100)->nullable();
            $table->text('error_message')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->index(['merchant_id', 'status', 'priority']);
            $table->index(['marketplace_connection_id', 'status']);
            $table->index(['entity_type', 'entity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_jobs');
    }
};
