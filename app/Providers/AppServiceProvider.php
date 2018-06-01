<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use DB;
use Log;
use Cache;
use App;
use Carbon\Carbon;

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

        view()->composer('admin.parent', function ($view) {
            $authUser = Auth::user();

            $view->with([
                'authUser' => $authUser
            ]);
        });

        view()->composer('front.parent', function ($view) {
            $totalChildren = Cache::remember('totalChildren', 15, function () {
                return DB::table('children')->count();
            });

            $totalFaculties = Cache::remember('activeFaculties', 15, function () {
                return DB::table('faculties')->whereNotNull('started_at')->count();
            });

            $view->with([
                'totalChildren'  => $totalChildren,
                'totalFaculties' => $totalFaculties
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
