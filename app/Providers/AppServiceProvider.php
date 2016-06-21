<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth, DB, Log, Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            Log::info( $query->sql . " |||| IN: " . $query->time);
            // $query->sql
            // $query->bindings
            // $query->time
        });

        view()->composer('admin.parent', function($view)
        {
            $authUser = Auth::user();
            $view->with([
                'authUser' => $authUser
            ]);
        });

        view()->composer('front.parent', function($view)
        {

            $totalChildren = Cache::remember('totalChildren', 15, function() {
                return DB::table('children')->count();
            });

            $totalFaculties = Cache::remember('activeFaculties', 15, function() {
                return DB::table('faculties')->whereNotNull('started_at')->count();
            });


            $view->with([
                'totalChildren' => $totalChildren,
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
