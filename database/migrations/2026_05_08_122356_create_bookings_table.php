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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')
                ->constrained()
                ->cascadeOnDelete();
                
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('tour_date_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->uuid('uuid')->unique();

            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);

            $table->string('payment_method')
                ->nullable();
            
            $table->string('payment_id')
                ->nullable();

            $table->decimal('subtotal', 10, 2);

            $table->decimal('commission_amount', 10, 2)
                ->default(0);

            $table->decimal('company_amount', 10, 2)
                ->default(0);

            $table->decimal('total', 10, 2);

            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
                'finished',
            ])->default('pending');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'refused',
                'refunded',
            ])->default('pending');

            $table->timestamp('expires_at')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            $table->index('status');
            $table->index('payment_status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
