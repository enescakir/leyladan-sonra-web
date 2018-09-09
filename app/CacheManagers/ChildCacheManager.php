<?php

namespace App\CacheManagers;

use DB;
use App\Models\Child;

class ChildCacheManager extends CacheManager
{
    public static function count($parameters = [])
    {
        $key = collect(['child-count'])->concat(array_values($parameters))->implode('-');
        return cache()->remember($key, static::SHORT_TERM_MINUTES, function () use ($parameters) {
            $query = Child::query();
            $query->when(array_key_exists('faculty_id', $parameters), function ($query2) use ($parameters) {
                $query2->where('faculty_id', $parameters['faculty_id']);
            })->when(array_key_exists('gift_status', $parameters), function ($query2) use ($parameters) {
                $query2->gift($parameters['gift_status']);
            });
            return $query->count();
        });
    }

    public static function countByGift($faculty_id = null)
    {
        $key = 'child-count-group' . ($faculty_id
                ? "-{$faculty_id}"
                : '');

        return cache()->remember($key, static::SHORT_TERM_MINUTES, function () use ($faculty_id) {
            return Child::select('gift_state', DB::raw('count(*) as total'))
                        ->groupBy('gift_state')
                        ->when($faculty_id, function ($query2) use ($faculty_id) {
                            $query2->where('faculty_id', $faculty_id);
                        })
                        ->get()
                        ->pluck('total', 'gift_state');
        });
    }

    public static function monthlyCount($parameters = [])
    {
        $parameters['monthCount'] = $parameters['monthCount'] ?? 10;

        $key = collect(['child-count-monthly'])->concat(array_values($parameters))->implode('-');

        return cache()->remember($key, static::LONG_TERM_MINUTES, function () use ($parameters) {
            $generalCounts = Child::get(['meeting_day'])->groupBy(function ($child) {
                return $child->meeting_day->format('Y-m');
            })->map->count();

            $facultyCounts = array_key_exists('faculty_id', $parameters)
                ? Child::where('faculty_id', $parameters['faculty_id'])
                       ->get(['faculty_id', 'meeting_day'])
                       ->groupBy(function ($child) {
                           return $child->meeting_day->format('Y-m');
                       })->map->count()
                : null;

            $result = [];
            for ($monthDiff = $parameters['monthCount']; $monthDiff > 0; $monthDiff--) {
                // TODO: Don't forget to remove subYear when production
                $month = now()->startOfMonth()->subYear()->subMonths($monthDiff);
                $key = $month->format('Y-m');

                $result[$key] = [
                    'month'   => $month->formatLocalized('%B'),
                    'year'    => $month->format('Y'),
                    'general' => $generalCounts->get($key, 0)
                ];
                if ($facultyCounts) {
                    $result[$key]['faculty'] = $facultyCounts->get($key, 0);
                }
            }
            return $result;
        });
    }

    public static function birthdays($faculty_id)
    {
        return cache()->remember("child-birthday-{$faculty_id}", static::LONG_TERM_MINUTES,
            function () use ($faculty_id) {
                $children = Child::where('faculty_id', $faculty_id)->get([
                    'first_name',
                    'last_name',
                    'faculty_id',
                    'birthday'
                ]);

                return $children->map(function ($child) {
                    return (object) [
                        'title'           => $child->full_name,
                        'start'           => $child->birthday->year(now()->year)->toDateString(),
                        'backgroundColor' => '#1bbc9b',
                        'repeat'          => 2
                    ];
                });
            });
    }
}
