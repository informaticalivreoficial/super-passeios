<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeCompanyNotification extends Notification
{
    use Queueable;   

    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bem-vindo à Plataforma Super Passeios')
            ->greeting('Olá ' . $notifiable->name)
            ->line('Sua conta foi criada com sucesso.')
            ->line('Agora valide seu email para acessar o painel.')
            ->action(
                'Validar Email',
                url('/email/verify')
            )
            ->line('Após a validação você poderá cadastrar sua empresa e começar a vender passeios.');
    }
}
