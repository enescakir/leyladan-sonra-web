<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Şifre Sıfırlama İşlemi 🔓')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line('Hesap şifreni sıfırlama isteğinde bulunduğun için bu e-postayı aldın.')
            ->line('Aşağıdaki düğmeye tıkla ve ilgili adımları takip et.')
            ->action('Şifremi Sıfırla', route('admin.password.reset', ['token' => $this->token, 'email' => $notifiable->email]))
            ->line('Eğer şifre sıfırlama talebinde bulunmadıysanız bu e-postayı önemsemeyin.');
    }

    public function toTelegram($notifiable)
    {
        $message = "`Şifremi Sıfırla` bağlantısına tıklayarak şifreni sıfırlayabilirsin 🔓";

        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content($message)
            ->animation('https://media.giphy.com/media/qugzlUdW5CkeI/giphy.gif')
            ->button('Şifremi Sıfırla', route('admin.password.reset', ['token' => $this->token, 'email' => $notifiable->email]));
    }

}
