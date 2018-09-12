<?php

namespace App\Services;

use App\Enums\FeedType;
use App\Enums\UserRole;
use App\Models\Feed;

class FeedService extends Service
{
    public function create($faculty, $type, $parameters = [], $role = UserRole::All, $link = null)
    {
        $desc = FeedType::getDescription($type);

        foreach ($parameters as $key => $value) {
            $desc = str_replace("[{$key}]", $value, $desc);
        }

        $feed = $faculty->feeds()->create([
            'title' => $role,
            'desc'  => $desc,
            'type'  => $type,
            'link'  => $link
        ]);

        return $feed;
    }
}
