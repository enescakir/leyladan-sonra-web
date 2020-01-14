<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedUser extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Hesabın artık aktif! 🎉')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line('Üyeliğin fakülte yöneticin tarafından onaylandı.')
            ->line('Artık sisteme giriş yapıp çocuk eklemeye başlayabilirsin.')
            ->action('Giriş Yap', route('admin.login'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
