<?php

namespace App\CacheManagers;

use App\Models\User;

class UserCacheManager extends CacheManager
{
    public static function count($parameters = [])
    {
        $key = collect(['user-count'])->concat(array_values($parameters))->implode('-');
        return cache()->remember($key, static::SHORT_TERM_MINUTES, function () use ($parameters) {
            $query = User::query();
            $query->when(array_key_exists('faculty_id', $parameters), function ($query2) use ($parameters) {
                $query2->where('faculty_id', $parameters['faculty_id']);
            })->when(array_key_exists('approval', $parameters), function ($query2) use ($parameters) {
                $query2->approved($parameters['approval']);
            });
            return $query->count();
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
