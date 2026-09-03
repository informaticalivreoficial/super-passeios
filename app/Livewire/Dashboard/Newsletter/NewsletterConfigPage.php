<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\NewsletterConfig;
use Livewire\Component;

class NewsletterConfigPage extends Component
{
    public string $from_name = 'SuperPasseios';

    public ?string $from_email = null;

    public ?string $reply_to = null;

    public bool $show_footer = true;

    public string $footer_text = 'Você recebeu este e-mail porque está inscrito na nossa newsletter.';

    public string $unsubscribe_text = 'Clique aqui para cancelar sua inscrição';

    public string $footer_background = '#f8fafc';

    public string $footer_text_color = '#64748b';

    public string $footer_link_color = '#16a3b7';

    public bool $show_address = true;

    public function mount(): void
    {
        $config = NewsletterConfig::instance();

        $this->from_name = $config->from_name ?? 'SuperPasseios';
        $this->from_email = $config->from_email ?? '';
        $this->reply_to = $config->reply_to ?? '';
        $this->show_footer = $config->show_footer;
        $this->footer_text = $config->footer_text ?? 'Você recebeu este e-mail porque está inscrito na nossa newsletter.';
        $this->unsubscribe_text = $config->unsubscribe_text ?? 'Clique aqui para cancelar sua inscrição';
        $this->footer_background = $config->footer_background ?? '#f8fafc';
        $this->footer_text_color = $config->footer_text_color ?? '#64748b';
        $this->footer_link_color = $config->footer_link_color ?? '#16a3b7';
        $this->show_address = $config->show_address;
    }

    public function save(): void
    {
        $this->validate([
            'from_name'        => 'required|string|max:255',
            'from_email'       => 'nullable|email|max:255',
            'reply_to'         => 'nullable|email|max:255',
            'footer_text'      => 'required|string|max:500',
            'unsubscribe_text' => 'required|string|max:255',
        ], [
            'from_name.required'        => 'Informe o nome do remetente.',
            'from_name.max'             => 'O nome não pode ter mais de 255 caracteres.',
            'from_email.email'          => 'Informe um e-mail válido.',
            'reply_to.email'            => 'Informe um e-mail válido.',
            'footer_text.required'      => 'Informe o texto do rodapé.',
            'footer_text.max'           => 'O texto do rodapé não pode ter mais de 500 caracteres.',
            'unsubscribe_text.required' => 'Informe o texto do link de descadastro.',
            'unsubscribe_text.max'      => 'O texto não pode ter mais de 255 caracteres.',
        ]);

        NewsletterConfig::instance()->update([
            'from_name'         => $this->from_name,
            'from_email'        => $this->from_email,
            'reply_to'          => $this->reply_to,
            'show_footer'       => $this->show_footer,
            'footer_text'       => $this->footer_text,
            'unsubscribe_text'  => $this->unsubscribe_text,
            'footer_background' => $this->footer_background,
            'footer_text_color' => $this->footer_text_color,
            'footer_link_color' => $this->footer_link_color,
            'show_address'      => $this->show_address,
        ]);

        $this->dispatch('swal:success', [
            'title' => 'Salvo!',
            'text'  => 'Configurações de e-mail atualizadas com sucesso.',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.newsletter.newsletter-config')->with([
            'title' => 'Configurações de E-mail',
        ]);
    }
}
