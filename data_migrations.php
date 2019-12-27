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
// approved_by -> approved_at
App\Models\User::chunk(100, function ($users) {
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
});


## FACULTY MIGRATIONS
$faculties = App\Models\Faculty::all();
$faculties->each(function ($faculty) {
    try {
        $faculty->addMedia(storage_path('app/public/faculty/' . $faculty->slug . '.png'));
    } catch (\Exception $e) {
        echo 'Message: ' . $e->getMessage() . "\n";
        echo 'Faculty #' . $faculty->id . "\n";
    }
});

## POST MIGRATIONS
$posts = App\Models\Post::with('images')->get();
$posts->each(function ($post) {
    try {
        $post->clearMediaCollection();

        $post->images->each(function ($image) use ($post){
            $post->addMedia(storage_path('app/public/child/' . $image->name), ['ratio' => $image->ratio]);
        });
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
});

$posts = App\Models\Post::with('child')->get();
$posts->each(function ($post) {
    if ($post->type == App\Enums\PostType::Meeting){
        $post->child->meetingPost()->associate($post);
        $post->child->save();
    } elseif ($post->type == App\Enums\PostType::Delivery){
        $post->child->deliveryPost()->associate($post);
        $post->child->save();
    }
});
