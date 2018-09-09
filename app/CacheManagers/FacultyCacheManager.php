<?php

namespace App\CacheManagers;

use App\Models\Faculty;

class FacultyCacheManager extends CacheManager
{
    public static function count($status = 'started')
    {
        $data = null;
        if ($status == 'all') {
            $data = cache()->remember('faculty-count', static::LONG_TERM_MINUTES, function () {
                return Faculty::count();
            });
        } elseif ($status == 'not-started') {
            $data = cache()->remember('faculty-count-not-started', static::LONG_TERM_MINUTES, function () {
                return Faculty::started(false)->count();
            });
        } else {
            $data = cache()->remember('faculty-count-started', static::LONG_TERM_MINUTES, function () {
                return Faculty::started()->count();
            });
        }
        return $data;
    }

    public static function counts()
    {
        return cache()->remember('faculty-counts', static::LONG_TERM_MINUTES, function () {
            return [
                'all'         => Faculty::count(),
                'started'     => Faculty::started()->count(),
                'not-started' => Faculty::started(false)->count()
            ];
        });
    }
}