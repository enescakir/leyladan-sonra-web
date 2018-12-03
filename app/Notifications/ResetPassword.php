<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
          ->subject('Şifre Sıfırlama İşlemi 🔓')
          ->greeting("Merhaba {$notifiable->first_name},")
          ->line('Hesap şifreni sıfırlama isteğinde bulunduğun için bu e-postayı aldın.')
          ->line('Aşağıdaki düğmeye tıkla ve ilgili adımları takip et.')
          ->action('Şifremi Sıfırla', route('admin.password.reset', [$this->token, 'email' => $notifiable->email]))
          ->line('Eğer şifre sıfırlama talebinde bulunmadıysanız bu e-postayı önemsemeyin.');
    }
}
