<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Booking;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\Vessel;
use App\Models\TourDate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Company::class  => \App\Policies\CompanyPolicy::class,
        Vessel::class   => \App\Policies\VesselPolicy::class,
        Tour::class     => \App\Policies\TourPolicy::class, 
        Booking::class  => \App\Policies\BookingPolicy::class,
        TourDate::class => \App\Policies\TourDatePolicy::class,
        Customer::class => \App\Policies\CustomerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
