<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_api_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('marketplace_connection_id')->constrained()->cascadeOnDelete();
            $table->string('operation', 100);
            $table->string('http_method', 10);
            $table->text('endpoint');
            $table->string('request_id', 200)->nullable();
            $table->uuid('correlation_id')->nullable()->index();
            $table->jsonb('request_payload')->nullable();
            $table->jsonb('response_payload')->nullable();
            $table->integer('http_status');
            $table->integer('duration_ms');
            $table->integer('rate_limit_remaining')->nullable();
            $table->timestamp('rate_limit_reset_at')->nullable();
            $table->boolean('success')->index();
            $table->string('error_code', 100)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['marketplace_connection_id', 'created_at']);
            $table->index(['merchant_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_api_logs');
    }
};
