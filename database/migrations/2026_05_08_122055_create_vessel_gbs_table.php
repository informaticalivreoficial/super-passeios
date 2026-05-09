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
        Schema::create('vessel_gbs', function (Blueprint $table) {
            $table->id();
            $table->integer('order_img')->default(0);
            $table->foreignId('vessel_id')->constrained('vessels')->cascadeOnDelete();
            $table->string('path');
            $table->boolean('cover')->nullable();
            $table->boolean('watermark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessel_gbs');
    }
};
