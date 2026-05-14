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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('vessel_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->uuid('uuid')->unique();

            $table->string('title');
            $table->string('slug')->unique();

            $table->enum('tour_type', [
                'private',
                'shared',
            ])->default('shared');

            $table->decimal('price', 10, 2);
            $table->integer('duration')->nullable();
            $table->string('boarding_place')->nullable();
            $table->text('description')->nullable();
            $table->text('rules')->nullable();
            $table->boolean('active')->default(true);
            $table->bigInteger('views')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
