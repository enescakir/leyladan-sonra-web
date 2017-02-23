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
        if (\App::environment('local')) {
//            DB::listen(function ($query) {
//                Log::info( $query->sql . " |||| IN: " . $query->time);
//                // $query->sql
//                // $query->bindings
//                // $query->time
//            });
        }

        view()->composer('admin.parent', function($view) {
            $authUser = Auth::user();
            if($authUser == null){
                Log::warning(
                    "authUser is null" . " - " . request()->method() . " - " . request()->path()
                );
                Auth::logout();
                return redirect()->guest('admin/login')->with('error_message', 'Bir sıkıntı ile karşılaşıldı. Durumu <strong>teknik@leyladansonra.com</strong> adresine bildirebilirsiniz');
            }

            $feeds = Cache::remember('faculty-feeds-' . $authUser->faculty_id, 5, function () use ($authUser) {
                return \App\Feed::where('faculty_id', $authUser->faculty_id)->orderby('id', 'desc')->limit(30)->get();
            });

            $chats = [];
            if ($authUser->title == "Yönetici" || $authUser->title == "Fakülte Sorumlusu" || $authUser->title == "İletişim Sorumlusu"){
                $chats = Cache::remember('faculty-chats-' . $authUser->faculty_id, 5, function () use ($authUser) {
                    return \App\Chat::where('faculty_id', $authUser->faculty_id)->with('messages', 'volunteer')->orderby('id', 'desc')->open()->get();
                });
            }
            $view->with([
                'authUser' => $authUser,
                'feeds' => $feeds,
                'chats' => $chats
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
