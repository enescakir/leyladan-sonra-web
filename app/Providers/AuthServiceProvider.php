<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Child'   => 'App\Policies\ChildPolicy',
        'App\Models\Blood'   => 'App\Policies\BloodPolicy',
        'App\Models\User'    => 'App\Policies\UserPolicy',
        'App\Models\Faculty' => 'App\Policies\FacultyPolicy',
        'App\Models\Post'    => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
