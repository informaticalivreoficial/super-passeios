<?php

namespace App\Livewire\Web;

use App\Mail\Web\Atendimento as AtendimentoMail;
use App\Models\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $whatsapp = '';
    public string $message = '';

    /** Honeypot: deve permanecer vazio. */
    public string $hp_campo_a = '';
    public string $hp_campo_b = '';

    public bool $enviado = false;

    private const LIMITE_TENTATIVAS = 3;

    private const JANELA_SEGUNDOS = 600;

    protected function rules(): array
    {
        return [
            'name' => 'required|min:3|max:120',
            'email' => 'required|email|max:180',
            'whatsapp' => 'nullable|max:30',
            'message' => 'required|min:10|max:2000',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Informe seu nome.',
            'name.min' => 'Seu nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'Seu nome deve ter no máximo 120 caracteres.',
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail deve ter no máximo 180 caracteres.',
            'whatsapp.max' => 'O telefone deve ter no máximo 30 caracteres.',
            'message.required' => 'Escreva sua mensagem.',
            'message.min' => 'Sua mensagem deve ter pelo menos 10 caracteres.',
            'message.max' => 'Sua mensagem deve ter no máximo 2000 caracteres.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'whatsapp' => 'WhatsApp',
            'message' => 'mensagem',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        if (trim($this->hp_campo_a) !== '' || trim($this->hp_campo_b) !== '') {
            Log::warning('Contato: envio bloqueado pelo honeypot', [
                'ip' => request()->ip(),
                'campos' => array_keys(array_filter([
                    'hp_campo_a' => trim($this->hp_campo_a),
                    'hp_campo_b' => trim($this->hp_campo_b),
                ])),
            ]);

            $this->simularEnvio();

            return;
        }

        $chave = 'contato:' . request()->ip();

        if (RateLimiter::tooManyAttempts($chave, self::LIMITE_TENTATIVAS)) {
            Log::warning('Contato: envio bloqueado por excesso de tentativas', [
                'ip' => request()->ip(),
            ]);

            $this->addError('form', 'Você fez muitas tentativas. Aguarde alguns minutos e tente novamente.');

            return;
        }

        RateLimiter::hit($chave, self::JANELA_SEGUNDOS);

        $destinatario = $this->destinatario();

        try {
            Mail::send(new AtendimentoMail([
                'sitename' => config('app.name'),
                'siteemail' => config('mail.from.address'),
                'contact_to' => $destinatario,
                'reply_name' => $this->name,
                'reply_email' => $this->email,
                'whatsapp' => $this->whatsapp,
                'mensagem' => $this->message,
            ]));
        } catch (\Throwable $e) {
            Log::error('Falha ao enviar mensagem de contato pelo site', [
                'email' => $this->email,
                'erro' => $e->getMessage(),
            ]);

            $this->addError('form', 'Não foi possível enviar sua mensagem agora. Tente novamente em instantes.');

            return;
        }

        Log::info('Contato: mensagem enviada', [
            'ip' => request()->ip(),
            'para' => $destinatario,
        ]);

        $this->reset(['name', 'email', 'whatsapp', 'message', 'hp_campo_a', 'hp_campo_b']);
        $this->resetValidation();
        $this->enviado = true;
    }

    public function novaMensagem(): void
    {
        $this->reset(['name', 'email', 'whatsapp', 'message', 'hp_campo_a', 'hp_campo_b']);
        $this->resetValidation();
        $this->enviado = false;
    }

    private function destinatario(): string
    {
        $configurado = trim((string) config('mail.contact_to'));

        if ($configurado !== '') {
            return $configurado;
        }

        try {
            $emailSite = trim((string) optional(Config::query()->first())->email);
        } catch (\Throwable $e) {
            $emailSite = '';
        }

        if ($emailSite !== '') {
            return $emailSite;
        }

        return (string) config('mail.from.address');
    }

    /**
     * Responde como sucesso para o bot, sem enviar e-mail.
     */
    private function simularEnvio(): void
    {
        $this->reset(['name', 'email', 'whatsapp', 'message', 'hp_campo_a', 'hp_campo_b']);
        $this->resetValidation();
        $this->enviado = true;
    }

    public function render()
    {
        return view('livewire.web.contact-form');
    }
}
