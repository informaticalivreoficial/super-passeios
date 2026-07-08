<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRequestedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Withdrawal $withdrawal
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $company = $this->withdrawal->company;

        return (new MailMessage)
            ->subject('Novo pedido de saque')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Uma operadora solicitou um saque na plataforma.')
            ->line('**Empresa:** ' . ($company->alias_name ?? $company->social_name))
            ->line('**Valor líquido:** R$ ' . number_format($this->withdrawal->net_amount, 2, ',', '.'))
            ->line('**Conta:** ' . $this->withdrawal->bankAccount?->label)
            ->action('Ver no painel', route('admin.withdrawals.index'))
            ->line('Acesse o painel para aprovar ou recusar.');
    }

    public function toArray(object $notifiable): array
    {
        $company = $this->withdrawal->company;

        return [
            'type'        => 'withdrawal_requested',
            'title'       => 'Novo pedido de saque',
            'message'     => ($company->alias_name ?? $company->social_name) . ' solicitou saque de R$ ' . number_format($this->withdrawal->net_amount, 2, ',', '.'),
            'description' => 'O saque está aguardando aprovação.',
            'color'       => 'warning',
            'url'         => route('admin.withdrawals.index'),
        ];
    }
}