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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('status')->default(true);

            /** access */
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('magic_token', 64)->nullable()->unique();
            $table->timestamp('magic_token_expires_at')->nullable();

            /** personal */
            $table->string('gender')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg', 20)->nullable();
            $table->string('rg_expedition')->nullable();
            $table->date('birthday')->nullable();
            $table->string('naturalness')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('avatar')->nullable();
            $table->string('additional_email')->nullable();

            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            $table->string('phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();            
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();

            $table->longText('information')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
