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
        Schema::create('vessels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->uuid('uuid')->unique();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('type');

            $table->integer('capacity')->default(1);

            $table->integer('year')->nullable();

            $table->decimal('size', 8, 2)->nullable();

            $table->text('description')->nullable();

            $table->boolean('bathroom')->default(false);
            $table->boolean('barbecue')->default(false);
            $table->boolean('suite')->default(false);
            $table->boolean('sound_system')->default(false);
            $table->boolean('kitchen')->default(false);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessels');
    }
};
