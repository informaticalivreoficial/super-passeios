<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(public float $amount) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Saldo liberado para saque',
            'message' => 'R$ ' . number_format($this->amount, 2, ',', '.') . ' já está disponível para saque.',
            'icon' => 'wallet',
            'color' => 'amber',
            'url' => route('company.wallet.index'),
        ];
    }
}
