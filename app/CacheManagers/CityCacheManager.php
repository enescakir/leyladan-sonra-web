<?php

namespace App\CacheManagers;

use App\Models\Faculty;

class CityCacheManager extends CacheManager
{
    public static function count($isStarted = true)
    {
        return cache()->remember('city-count', static::LONG_TERM_MINUTES, function () use ($isStarted) {
            return Faculty::when($isStarted, function ($query) {
                return $query->started();
            })->groupBy('code')->count();
        });
    }

    public static function colors()
    {
        return cache()->remember('city-colors', static::LONG_TERM_MINUTES, function () {
            return Faculty::all()->groupBy('code')->map(function ($faculties) {
                return $faculties->where('started_at', '<>', null)->isEmpty()
                    ? '#fcd5ae'
                    : '#339999';
            });
        });
    }

    public static function faculties($cityCode)
    {
        return cache()->remember("city-faculties-{$cityCode}", static::LONG_TERM_MINUTES, function () use ($cityCode) {
            return Faculty::where('code', $cityCode)->get(['name', 'started_at']);
        });
    }
}
