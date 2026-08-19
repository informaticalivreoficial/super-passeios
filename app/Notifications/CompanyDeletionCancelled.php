<?php

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyDeletionCancelled extends Notification
{
    use Queueable;

    public function __construct(
        protected Company $company
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Exclusão da conta cancelada')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('A exclusão da conta da empresa **' . $this->company->alias_name . '** foi cancelada.')
            ->line('Sua conta continua ativa normalmente. Qualquer dúvida, fale com a gente!')
            ->action('Acessar painel', route('company.dashboard'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'company_deletion_cancelled',
            'title'       => 'Exclusão cancelada',
            'message'     => 'A exclusão da sua conta foi cancelada.',
            'description' => 'Sua conta continua ativa normalmente.',
            'color'       => 'green',
            'url'         => route('company.dashboard'),
        ];
    }
}