<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

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

    public function toTelegram($notifiable)
    {
        $message = "*Hesabın artık aktif* 🎉 Sisteme giriş yapıp çocuk eklemeye başlayabilirsin";

        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content($message)
            ->animation('https://media.giphy.com/media/11sBLVxNs7v6WA/giphy.gif')
            ->button('Giriş Yap', route('admin.login'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
