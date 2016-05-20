<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth, DB, Log;

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
            $totalChildren = DB::table('children')->count();
            $totalFaculties = DB::table('faculties')->count();

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
