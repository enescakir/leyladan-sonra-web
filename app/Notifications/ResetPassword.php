<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
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
          ->subject('Şifre Sıfırlama İşlemi')
          ->line('Hesap şifrenizi sıfırlama isteğinde bulunduğunuz için bu e-postayı aldınız.')
          ->line('Aşağıdaki butona tıklayınız ve ilgili adımları takip ediniz.')
          ->action('Şifremi Sıfırla', url('admin/password/reset', $this->token))
          ->line('Eğer şifre sıfırlama talebinde bulunmadıysanız bu e-postayı önemsemeyin.');
    }
}
