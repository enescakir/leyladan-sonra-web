<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ActivateEmail extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        if ($notifiable->shouldSendMail()) {
            return ['mail'];
        }

        return [];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('E-posta Doğrulama İşlemi 💌')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line('E-posta adresini doğrulamak için aşağıdaki bağlantıya tıklaman gerekiyor.')
            ->action('Doğrula', url('admin/email/activation', ['token' => $this->token]))
            ->line('Eğer bu e-posta adresinizle Leyla\'dan Sonra Sistemi\'ne kayıt olmadıysanız bu e-postayı önemsemeyin.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
