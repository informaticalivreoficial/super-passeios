<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCompanyRegistered extends Notification
{
    use Queueable;

    public function __construct(
        protected Customer $customer
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nova empresa cadastrada')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Uma nova empresa se cadastrou na plataforma.')
            ->line('**Nome:** ' . $this->customer->name)
            ->line('**E-mail:** ' . $this->customer->email)
            ->line('**Telefone:** ' . $this->customer->cell_phone)
            ->action('Ver no painel', route('admin.companies.index'))
            ->line('Acesse o painel para gerenciar.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'           => 'new_company',
            'title' => 'Nova empresa cadastrada',
            'message' => "Empresa {$this->customer->name} se cadastrou na plataforma.",
            'description' => "A empresa está aguardando aprovação.",
            'color' => 'success',
            'url' => route('admin.companies.index')
        ];
    }
}