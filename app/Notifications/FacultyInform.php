<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FacultyInform extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sender;
    protected $subject;
    protected $body;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $sender)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->sender = $sender;
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
            ->subject($this->subject)
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line($this->body)
            ->line("Leyla'dan Sonra ekibinden {$this->sender}");
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
