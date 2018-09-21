<?php

namespace App\Http\Controllers\Admin\Child;

use App\Enums\GiftStatus;
use App\Http\Controllers\Admin\AdminController;
use App\Services\ProcessService;
use App\Services\FeedService;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Enums\FeedType;
use App\Enums\ProcessType;
use App\Notifications\GiftArrived as GiftArrivedNotification;
use Notification;

class ChildPostController extends AdminController
{
    protected $processService;
    protected $feedService;

    public function __construct(ProcessService $processService, FeedService $feedService)
    {
        $this->processService = $processService;
        $this->feedService = $feedService;
    }

    public function store(Request $request, Child $child)
    {
        $process = $this->processService->create($child, $request->type);

        if ($process->type == ProcessType::GiftArrived) {
            $child->gift_state = GiftStatus::Arrived;
            $child->save();

            Notification::send($child->users, new GiftArrivedNotification($child));

            $this->feedService->create($child->faculty, FeedType::GiftArrived, ['child' => $child->full_name]);
        } elseif ($process->type == ProcessType::VolunteerFound) {
            $child->gift_state = GiftStatus::OnRoad;
            $child->save();

            $this->feedService->create($child->faculty, FeedType::VolunteerFound, ['child' => $child->full_name]);
        } elseif ($process->type == ProcessType::GiftDelivered) {
            $child->gift_state = GiftStatus::Delivered;
            $child->save();

            $this->feedService->create($child->faculty, FeedType::GiftDelivered, ['child' => $child->full_name]);
        } elseif ($process->type == ProcessType::Reset) {
            $child->gift_state = GiftStatus::Waiting;
            $child->save();

            $this->feedService->create($child->faculty, FeedType::ChildReset, ['child' => $child->full_name]);
        }

        $process->loadMissing('creator');
        return api_success([
            'process'          => $process,
            'label'            => $child->gift_state_label,
            'created_at_label' => $process->created_at_label
        ]);
    }
}
