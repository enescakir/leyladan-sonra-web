<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ApprovedUser extends Notification
{
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
