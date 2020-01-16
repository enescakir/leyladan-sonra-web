<?php

namespace App\Providers;

use App\Enums\UserRole;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Child'        => 'App\Policies\ChildPolicy',
        'App\Models\Blood'        => 'App\Policies\BloodPolicy',
        'App\Models\User'         => 'App\Policies\UserPolicy',
        'App\Models\Faculty'      => 'App\Policies\FacultyPolicy',
        'App\Models\Post'         => 'App\Policies\PostPolicy',
        'App\Models\Volunteer'    => 'App\Policies\VolunteerPolicy',
        'App\Models\Chat'         => 'App\Policies\ChatPolicy',
        'App\Models\Department'   => 'App\Policies\DepartmentPolicy',
        'App\Models\WishCategory' => 'App\Policies\WishCategoryPolicy',
        'App\Models\Diagnosis'    => 'App\Policies\DiagnosisPolicy',
        'App\Models\Material'     => 'App\Policies\MaterialPolicy',
        'App\Models\EmailSample'  => 'App\Policies\EmailSamplePolicy',
        'App\Models\Tutorial'     => 'App\Policies\TutorialPolicy',
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

        Gate::before(function ($user, $ability) {
            if ($user->hasRole(UserRole::Admin)) {
                return true;
            }

            if (!$user->isApproved() || $user->hasRole(UserRole::Left)) {
                return false;
            }
        });

        Gate::define('website-content', function ($user) {
            return $user->hasAnyRole([
                UserRole::Admin,
                UserRole::Content,
            ]);
        });

        Auth::provider('custom', function ($app, $config) {
            return new CustomUserProvider($app['hash'], $config['model']);
        });
    }
}
