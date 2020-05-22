<?php

namespace App\Services;

use App\Enums\FeedType;
use App\Enums\GiftStatus;
use App\Enums\ProcessType;
use App\Enums\UserRole;

class FeedService extends Service
{
    static function create($faculty, $type, $parameters = [], $role = UserRole::All, $link = null)
    {
        $desc = FeedType::getDescription($type);

        foreach ($parameters as $key => $value) {
            $desc = str_replace("[{$key}]", $value, $desc);
        }

        return $faculty->feeds()->create([
            'title' => $role,
            'desc'  => $desc,
            'type'  => $type,
            'link'  => $link
        ]);
    }

    static function fromProcess($process)
    {
        $type = null;

        switch ($process->type) {
            case ProcessType::GiftArrived:
                $type = FeedType::GiftArrived;
                break;
            case ProcessType::VolunteerFound:
                $type = FeedType::VolunteerFound;
                break;
            case ProcessType::GiftDelivered:
                $type = FeedType::GiftDelivered;
                break;
            case ProcessType::Reset:
                $type = FeedType::ChildReset;
                break;
            default:
                return null;
        }

        return FeedService::create($process->child->faculty, $type, ['child' => $process->child->full_name]);
    }
}
