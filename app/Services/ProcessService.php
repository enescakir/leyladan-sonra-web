<?php

namespace App\Services;

use App\Enums\GiftStatus;
use App\Enums\ProcessType;

class ProcessService extends Service
{

    static function create($child, $type, $processable = null)
    {
        $process = $child->processes()->create([
            'type' => $type,
        ]);
        if ($processable) {
            $process->processable()->save($processable);
        }

        switch ($process->type) {
            case ProcessType::GiftArrived:
                $child->gift_state = GiftStatus::Arrived;
                NotificationService::sendGiftArrivedNotification($child);
                break;
            case ProcessType::VolunteerFound:
                $child->gift_state = GiftStatus::OnRoad;
                break;
            case ProcessType::GiftDelivered:
                $child->gift_state = GiftStatus::Delivered;
                NotificationService::sendGiftDeliveredNotification($child);
                break;
            case ProcessType::Reset:
                $child->gift_state = GiftStatus::Waiting;
                break;
        }

        $child->save();

        return $process;
    }

    static function createPost($child, $approval, $post)
    {
        $processType = $approval
            ? ProcessType::PostApproved
            : ProcessType::PostUnapproved;

        return static::create($child, $processType, $post);
    }
}