<?php

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyDeletionRequested extends Notification
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
            ->subject('Empresa solicitou exclusão da conta')
            ->greeting('Olá!')
            ->line("A empresa **{$this->company->alias_name}** solicitou a exclusão da conta.")
            ->line('A exclusão será efetivada automaticamente em **' . $this->company->deletion_scheduled_for->format('d/m/Y') . '**.')
            ->action('Ver empresa', route('admin.companies.edit', $this->company))
            ->line('Caso necessário, entre em contato com o responsável.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'company_deletion_requested',
            'title'       => 'Exclusão de conta solicitada',
            'message'     => "A empresa {$this->company->alias_name} solicitou a exclusão da conta.",
            'description' => 'A exclusão será efetivada em ' . $this->company->deletion_scheduled_for->format('d/m/Y') . '.',
            'color'       => 'red',
            'url'         => route('admin.companies.edit', $this->company),
        ];
    }
}