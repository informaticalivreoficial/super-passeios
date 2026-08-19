<?php

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyDeletionScheduled extends Notification
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
            ->subject('Sua conta será excluída em ' . $this->company->deletion_scheduled_for->format('d/m/Y'))
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Recebemos a solicitação de exclusão da conta da empresa **' . $this->company->alias_name . '**.')
            ->line('Sua conta será excluída permanentemente em **' . $this->company->deletion_scheduled_for->format('d/m/Y') . '**.')
            ->line('Se mudar de ideia, você pode cancelar a exclusão dentro desse período acessando o painel.')
            ->action('Cancelar exclusão', route('company.company.edit', $this->company->uuid))
            ->line('Obrigado por fazer parte da nossa plataforma!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'company_deletion_scheduled',
            'title'       => 'Exclusão agendada',
            'message'     => 'Sua conta será excluída em ' . $this->company->deletion_scheduled_for->format('d/m/Y') . '.',
            'description' => 'Você pode cancelar a exclusão dentro desse período.',
            'color'       => 'red',
            'url'         => route('company.company.edit', $this->company->uuid),
        ];
    }
}