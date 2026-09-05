<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operator_document_acceptances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_id')->constrained('operator_documents')->cascadeOnDelete();
            $table->string('version', 20);
            $table->string('content_hash', 64);
            $table->timestamp('accepted_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();

            $table->unique(['customer_id', 'document_id', 'version'], 'oda_cust_doc_ver_unique');
            $table->index('customer_id');
            $table->index('document_id');
            $table->index('version');
            $table->index('accepted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operator_document_acceptances');
    }
};
