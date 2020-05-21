<?php

namespace App\CacheManagers;

use App\Models\Blood;
use App\Models\Child;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Faculty;
use App\Models\Feed;

class CacheManager
{

    const SHORT_TERM_MINUTES = 15 * 60;
    const LONG_TERM_MINUTES = 600 * 60;

    public static function counts()
    {
        return cache()->remember('active-counts', static::SHORT_TERM_MINUTES, function () {
            return [
                'blood'     => Blood::count(),
                'volunteer' => Volunteer::count(),
                'faculty'   => Faculty::started()->count(),
                'child'     => Child::count(),
                'user'      => User::approved()
                    ->whereNull('left_at')
                    ->whereNull('graduated_at')
                    ->whereHas('faculty', function ($query) {
                        $query->stopped(false);
                    })->count(),
                'city'      => Faculty::started()->get()->groupBy('code')->count()
            ];
        });
    }

    public static function bloodCount()
    {
        return cache()->remember('blood-count', CacheManager::SHORT_TERM_MINUTES, function () {
            return Blood::count();
        });
    }

    public static function volunteerCount()
    {
        return cache()->remember('volunteer-count', CacheManager::SHORT_TERM_MINUTES, function () {
            return Volunteer::count();
        });
    }

    public static function feeds($faculty_id = null, $limit = 15)
    {
        if ($faculty_id) {
            return cache()->remember('feed-' . $faculty_id, CacheManager::SHORT_TERM_MINUTES, function () use ($faculty_id, $limit) {
                return Feed::where('faculty_id', $faculty_id)
                    ->orderby('id', 'desc')
                    ->with('creator')
                    ->limit($limit)
                    ->get();
            });
        }
        return cache()->remember('feed', CacheManager::SHORT_TERM_MINUTES, function () use ($limit) {
            return Feed::orderby('id', 'desc')->limit($limit)->with('creator')->get();
        });
    }
}