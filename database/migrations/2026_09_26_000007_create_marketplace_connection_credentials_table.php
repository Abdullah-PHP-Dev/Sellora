<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketplace_connection_credentials', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('marketplace_connection_id');

            $table->string('credential_type', 50)->default('oauth2');

            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();

            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable();

            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();

            $table->json('scopes')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('refresh_expires_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['marketplace_connection_id', 'credential_type'],
                'mcc_connection_type_unique'
            );

            $table->foreign(
                'marketplace_connection_id',
                'mcc_connection_fk'
            )
            ->references('id')
            ->on('marketplace_connections')
            ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplace_connection_credentials');
    }
};