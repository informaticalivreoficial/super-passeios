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
use App\Policies\Customer\TourDatePolicy as CustomerTourDatePolicy;
use App\Policies\Customer\BookingPolicy as CustomerBookingPolicy;
use App\Policies\Customer\CompanyPolicy as CustomerCompanyPolicy;
use App\Policies\Customer\CustomerPolicy;
use App\Policies\Customer\TourPolicy as CustomerTourPolicy;
use App\Policies\Customer\VesselPolicy as CustomerVesselPolicy;
use Illuminate\Support\Facades\Gate;

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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::policy(Company::class,  CustomerCompanyPolicy::class);
        Gate::policy(Vessel::class,   CustomerVesselPolicy::class);
        Gate::policy(Tour::class,     CustomerTourPolicy::class);
        Gate::policy(Booking::class,  CustomerBookingPolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(TourDate::class, CustomerTourDatePolicy::class);
    }
}
