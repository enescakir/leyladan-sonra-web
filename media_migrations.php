<?php

$channels = App\Models\Channel::whereNotNull('logo')->get();
$channels->each(function ($channel) {
    try {
        $channel
            ->addMedia(storage_path('app/public/channel/' . $channel->logo))
            ->sanitizingFileName(function ($fileName) use ($channel) {
                return $channel->id . str_random(5) . '.' . explode('.', $fileName)[1];
            })
            ->toMediaCollection();
    } catch (\Exception $e) {
        echo 'Message: ' . $e->getMessage() . "\n";
        echo 'Channel #' . $channel->id . "\n";
    }
});
