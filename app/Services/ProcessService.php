<?php

namespace App\Services;

use App\Enums\ProcessType;

class ProcessService extends Service
{

    public function create($child, $type, $processable = null)
    {
        $process = $child->processes()->create([
            'type' => $type,
        ]);
        if ($processable) {
            $process->processable()->save($processable);
        }
        return $process;
    }

    public function createPost($child, $approval, $post)
    {
        $processType = $approval
            ? ProcessType::PostApproved
            : ProcessType::PostUnapproved;

        return $this->createProcess($child, $processType, $post);
    }
}