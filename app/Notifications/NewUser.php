<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Fakültenden onay bekleyen üyeler var!')
                    ->greeting("Merhaba {$notifiable->first_name},")
                    ->line('Fakültene kayıtlı <strong>' . $this->user->full_name . '</strong> sistemimize <strong><em>' . $this->user->role_display . '</strong></em> olarak ' . $this->user->email . ' e-posta adresi ile kayıt oldu.')
                    ->line('Sisteme giriş yaparak "Üyeler > Onay Bekleyen Üyeler" sayfasından üyeliği onaylayabilirsin.')
                    ->action('Üyeyi Onayla', route('admin.faculty.users.unapproved', $this->user->faculty_id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
