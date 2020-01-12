<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\CacheManagers\ChildCacheManager;
use App\CacheManagers\FacultyCacheManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('tr');
        setlocale(LC_ALL, 'tr_TR.utf8') or setlocale(LC_ALL, 'tr_TR.utf-8');

        view()->composer('admin.layouts.app', function ($view) {
            $view->with([
                'authUser' => Auth::user()
            ]);
        });

        view()->composer('front.parent', function ($view) {
            $view->with([
                'totalChildren'  => ChildCacheManager::count(),
                'totalFaculties' => FacultyCacheManager::count()
            ]);
        });

        Relation::morphMap([
            'children'   => 'App\Models\Children',
            'volunteers' => 'App\Models\Volunteer',
            'users'      => 'App\Models\User',
            'posts'      => 'App\Models\Post',
            'faculties'  => 'App\Models\Faculty',
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Builder::macro('download', function ($name, $mapper = null) {
            $elements = $this->get();

            if (is_callable($mapper)) {
                $elements = $elements->map($mapper);
            }

            abort($elements->downloadExcel("{$name}.xlsx", null, true));
        });

    }
}
