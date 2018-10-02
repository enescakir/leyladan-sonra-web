<?php

namespace App\CacheManagers;

use App\Models\Chat;
use DB;

class ChatCacheManager extends CacheManager
{
    public static function count($parameters = [])
    {
        $key = collect(['chat-count'])->concat(array_values($parameters))->implode('-');
        return cache()->remember($key, static::SHORT_TERM_MINUTES, function () use ($parameters) {
            $query = Chat::query();
            $query->when(array_key_exists('faculty_id', $parameters), function ($query2) use ($parameters) {
                $query2->where('faculty_id', $parameters['faculty_id']);
            })->when(array_key_exists('status', $parameters), function ($query2) use ($parameters) {
                $query2->where('status', $parameters['status']);
            });
            return $query->count();
        });
    }
}
