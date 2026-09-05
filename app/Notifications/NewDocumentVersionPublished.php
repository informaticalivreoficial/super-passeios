<?php

namespace App\Notifications;

use App\Models\OperatorDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDocumentVersionPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public OperatorDocument $document
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'document_version_published',
            'title'       => 'Novo documento disponível',
            'message'     => "Uma nova versão do documento \"{$this->document->title}\" (v{$this->document->version}) está disponível para aceite.",
            'description' => $this->document->is_required
                ? 'Este documento é obrigatório e precisa ser aceito.'
                : 'Este documento é opcional.',
            'color'       => 'blue',
            'url'         => route('company.documents.show', $this->document->id),
            'document_id' => $this->document->id,
            'version'     => $this->document->version,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Novo documento disponível para aceite')
            ->greeting("Olá {$notifiable->name}!")
            ->line("Uma nova versão do documento \"{$this->document->title}\" (v{$this->document->version}) está disponível.")
            ->line($this->document->is_required ? 'Este documento é **obrigatório**.' : 'Este documento é opcional.')
            ->action('Visualizar Documento', route('company.documents.show', $this->document->id))
            ->line('Acesse o painel para visualizar e aceitar o documento.');
    }
}
