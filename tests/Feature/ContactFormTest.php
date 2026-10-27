<?php

namespace Tests\Feature;

use App\Livewire\Web\ContactForm;
use App\Mail\Web\Atendimento;
use App\Models\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::clear('contato:127.0.0.1');
        Mail::fake();
    }

    public function test_submit_vazio_retorna_erros_de_validacao(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'message'])
            ->assertSet('enviado', false);

        Mail::assertNothingSent();
    }

    public function test_envia_mensagem_valida(): void
    {
        config(['mail.contact_to' => 'contato@example.com']);

        Livewire::test(ContactForm::class)
            ->set('name', 'Maria Silva')
            ->set('email', 'maria@example.com')
            ->set('whatsapp', '(12) 99999-9999')
            ->set('message', 'Gostaria de saber mais sobre os passeios.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('enviado', true);

        Mail::assertSent(Atendimento::class, function (Atendimento $mail) {
            return $mail->hasTo('contato@example.com')
                && $mail->hasReplyTo('maria@example.com');
        });
    }

    public function test_honeypot_responde_com_sucesso_sem_enviar(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Robô')
            ->set('email', 'bot@example.com')
            ->set('message', 'Mensagem enviada por um robô de spam.')
            ->set('hp_campo_a', 'preenchido')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('enviado', true);

        Mail::assertNothingSent();
    }

    public function test_bloqueia_apos_tres_tentativas(): void
    {
        for ($i = 0; $i < 3; $i++) {
            Livewire::test(ContactForm::class)
                ->set('name', 'Maria Silva')
                ->set('email', 'maria@example.com')
                ->set('message', 'Mensagem válida com mais de dez caracteres.')
                ->call('submit')
                ->assertSet('enviado', true);
        }

        Livewire::test(ContactForm::class)
            ->set('name', 'Maria Silva')
            ->set('email', 'maria@example.com')
            ->set('message', 'Mensagem válida com mais de dez caracteres.')
            ->call('submit')
            ->assertHasErrors('form')
            ->assertSet('enviado', false);
    }

    public function test_pagina_de_atendimento_renderiza_formulario(): void
    {
        $config = Config::create([
            'app_name' => 'Super Passeios',
            'template' => 'default',
            'email' => 'sac@superpasseios.com.br',
            'init_date' => now()->year,
        ]);

        View::share('config', $config);

        $this->get(route('web.contact'))
            ->assertOk()
            ->assertSee('Fale com a gente')
            ->assertSee('Enviar mensagem');
    }
}
