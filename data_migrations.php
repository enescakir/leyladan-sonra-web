<?php


## CHANNEL MIGRATIONS
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

## SPONSOR MIGRATIONS
$sponsors = App\Models\Sponsor::whereNotNull('logo')->get();
$sponsors->each(function ($sponsor) {
    try {
        $sponsor
            ->addMedia(storage_path('app/public/sponsor/' . $sponsor->logo))
            ->sanitizingFileName(function ($fileName) use ($sponsor) {
                return $sponsor->id . str_random(5) . '.' . explode('.', $fileName)[1];
            })
            ->toMediaCollection();
    } catch (\Exception $e) {
        echo 'Message: ' . $e->getMessage() . "\n";
        echo 'Sponsor #' . $sponsor->id . "\n";
    }
});

## USER MIGRATIONS
$users = App\Models\User::get();
$users->each(function ($user) {
    switch ($user->title) {
        case 'Yönetici':
            $user->assignRole('admin');
            break;
        case 'Fakülte Sorumlusu':
            $user->assignRole('manager');
            break;
        case 'Fakülte Yönetim Kurulu':
            $user->assignRole('board');
            break;
        case 'İletişim Sorumlusu':
            $user->assignRole('relation');
            break;
        case 'Site Sorumlusu':
            $user->assignRole('website');
            break;
        case 'Kan Bağışı Görevlisi':
            $user->assignRole('blood');
            break;
        case 'Hediye Sorumlusu':
            $user->assignRole('gift');
            break;
        default:
            $user->assignRole('normal');
            break;
    }
});
