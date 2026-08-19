<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->timestamp('deletion_requested_at')->nullable()->after('status');
            $table->timestamp('deletion_scheduled_for')->nullable()->after('deletion_requested_at');
            $table->timestamp('deletion_cancelled_at')->nullable()->after('deletion_scheduled_for');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['deletion_requested_at', 'deletion_scheduled_for', 'deletion_cancelled_at']);
        });
    }
};