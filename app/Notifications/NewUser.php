<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;

class NewUser extends Notification
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Fakültenden onay bekleyen üyeler var! 👑️')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line("Fakültene kayıtlı <strong>{$this->user->full_name}</strong> sisteme <strong><em>{$this->user->role_display}</strong></em> olarak <strong>{$this->user->email}</strong> e-posta adresi ile kayıt oldu.")
            ->line("Sisteme giriş yaparak '<em>Üyeler > Onay Bekleyenler</em>' sayfasından üyeliği onaylayabilirsin.")
            ->action('Üyeyi Onayla', route('admin.faculty.user.index', ['faculty' => $this->user->faculty_id, 'approval' => 0]));
    }

    public function toTelegram($notifiable)
    {
        $message = "Fakültenden *{$this->user->full_name}* sisteme *{$this->user->role_display}* olarak kayıt oldu";

        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content($message)
            ->animation('https://media.giphy.com/media/iUOzkJmvnFfqM/giphy.gif')
            ->button('Üyeyi Onayla', route('admin.faculty.user.index', ['faculty' => $this->user->faculty_id, 'approval' => 0]));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
