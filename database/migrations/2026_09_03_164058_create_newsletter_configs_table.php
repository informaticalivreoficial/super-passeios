<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_configs', function (Blueprint $table) {
            $table->id();
            $table->string('from_name')->default('SuperPasseios');
            $table->string('from_email')->nullable();
            $table->string('reply_to')->nullable();
            $table->boolean('show_footer')->default(true);
            $table->text('footer_text')->default('Você recebeu este e-mail porque está inscrito na nossa newsletter.');
            $table->string('unsubscribe_text')->default('Clique aqui para cancelar sua inscrição');
            $table->string('footer_background')->default('#f8fafc');
            $table->string('footer_text_color')->default('#64748b');
            $table->string('footer_link_color')->default('#16a3b7');
            $table->boolean('show_address')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_configs');
    }
};
