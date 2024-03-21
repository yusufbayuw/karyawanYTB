<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\ActivityPolicy;
use App\Policies\UserActivityPolicy;
use Edwink\FilamentUserActivity\Models\UserActivity;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Activity::class => ActivityPolicy::class,
        UserActivity::class => UserActivityPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
