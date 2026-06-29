<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();            

            $table->enum('type', ['pix', 'ted'])->default('pix');

            // PIX
            $table->enum('pix_type', [
                'cpf',
                'cnpj',
                'email',
                'phone',
                'random',
            ])->nullable();
            $table->string('pix_key')->nullable();

            // TED
            $table->string('bank_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('agency')->nullable();
            $table->string('agency_digit')->nullable();
            $table->string('account')->nullable();
            $table->string('account_digit')->nullable();
            $table->enum('account_type', ['checking', 'savings'])->nullable();

            // Titular
            $table->string('holder_name');
            $table->string('holder_document'); // CPF ou CNPJ

            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
