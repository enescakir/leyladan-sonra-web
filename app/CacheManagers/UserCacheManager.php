<?php

namespace App\CacheManagers;

use App\Models\User;

class UserCacheManager extends CacheManager
{
    public static function count()
    {
        return cache()->remember('user-count', static::SHORT_TERM_MINUTES, function () {
            return User::count();
        });
    }

    public static function birthdays($faculty_id)
    {
        return cache()->remember("user-birthday-{$faculty_id}", static::LONG_TERM_MINUTES, function () use ($faculty_id) {
            $users = User::where('faculty_id', $faculty_id)->get(['first_name', 'last_name', 'faculty_id', 'birthday']);

            return $users->map(function ($user) {
                return (object) [
                    'title'           => $user->full_name,
                    'start'           => $user->birthday->year(now()->year)->toDateString(),
                    'backgroundColor' => '#F3565D',
                    'repeat'          => 2
                ];
            });
        });
    }
}
