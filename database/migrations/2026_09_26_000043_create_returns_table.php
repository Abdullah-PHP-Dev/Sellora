<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('external_return_id', 200)->nullable();
            $table->string('return_number');
            $table->string('status', 30)->default('requested')->index();
            $table->string('reason')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->jsonb('metadata')->nullable();
            $table->timestamps();
            $table->unique(['merchant_id', 'return_number']);
            $table->unique(['order_id', 'external_return_id'], 'return_order_ext_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
