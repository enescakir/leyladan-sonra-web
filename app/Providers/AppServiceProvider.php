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
