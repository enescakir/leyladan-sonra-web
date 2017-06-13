<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUser extends Notification
{
    use Queueable;

    public $newUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($newUser)
    {
        $this->newUser = $newUser;
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
                    ->subject("Fakültenizden onay bekleyen üyeler var!")
                    ->line('Fakültenizden <strong>' . $this->newUser->full_name . '</strong> sistemimize <strong><em>' . $this->newUser->title . '</strong></em> olarak ' . $this->newUser->email . ' e-posta adresi ile kayıt oldu.')
                    ->line('Sisteme giriş yaparak "Üyeler > Onay Bekleyen Üyeler" sayfasından üyeliği onaylayabilirsiniz.')
                    ->action('Üyeyi Onayla', route('admin.faculty.users.unapproved', $this->newUser->faculty_id ));
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
