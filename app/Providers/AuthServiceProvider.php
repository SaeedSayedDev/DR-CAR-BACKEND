<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\BookingAd;
use App\Models\MaintenanceReport;
use App\Policies\BookingAdPolicy;
use App\Policies\MaintenanceReportPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BookingAd::class => BookingAdPolicy::class,
        MaintenanceReport::class => MaintenanceReportPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
