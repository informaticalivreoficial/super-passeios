<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Company;
use App\Observers\BookingObserver;
use App\Policies\CompanyPolicy;
use App\Models\TourDate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Booking::observe(BookingObserver::class);
        Gate::policy(Company::class, CompanyPolicy::class);

        Paginator::useBootstrap();

        $config = \App\Models\Config::first(); 
        View()->share('config', $config);

        VerifyEmail::toMailUsing(function ($notifiable, $url) {

            return (new MailMessage)
                ->subject('Bem-vindo à Plataforma Náutica')
                ->greeting('Olá ' . $notifiable->name)
                ->line('Sua conta foi criada com sucesso.')
                ->line('Agora valide seu email para acessar o painel.')
                ->action('Validar Email', $url)
                ->line('Após a validação você poderá cadastrar sua empresa.');
        });

        // Compartilhar a variável $hasOpenReservations com todas as views
        View::composer('web.default.master.footer', function ($view) {
            $hasOpenReservations = cache()->remember(
                'home.has_open_reservations',
                now()->addMinutes(5),
                fn () => TourDate::available()->exists()
            );

            $view->with('hasOpenReservations', $hasOpenReservations);
        });
    }
}
