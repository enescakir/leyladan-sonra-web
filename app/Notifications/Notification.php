<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramChannel;

class Notification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        if ($notifiable->shouldSendTelegram()) {
            return [TelegramChannel::class];
        }

        if ($notifiable->shouldSendMail()) {
            return ['mail'];
        }

        return [];
    }
}
