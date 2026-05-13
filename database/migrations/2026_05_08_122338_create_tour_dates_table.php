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
        Schema::create('tour_dates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('date');
            $table->decimal('price', 10, 2)->nullable();
            
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('available_slots')->default(0);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_dates');
    }
};
