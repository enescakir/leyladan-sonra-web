<?php

namespace App\CacheManagers;

use App\Models\Post;

class PostCacheManager extends CacheManager
{
    public static function count($parameters = [])
    {
        $key = collect(['post-count'])->concat(array_values($parameters))->implode('-');
        return cache()->remember($key, static::SHORT_TERM_MINUTES, function () use ($parameters) {
            $query = Post::query();
            $query->when(array_key_exists('faculty_id', $parameters), function ($query2) use ($parameters) {
                $query2->faculty($parameters['faculty_id']);
            })->when(array_key_exists('approval', $parameters), function ($query2) use ($parameters) {
                $query2->approved($parameters['approval']);
            });
            return $query->count();
        });
    }
}
