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

    public function __construct($subject, $body, $sender)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line($this->body)
            ->line("Leyla'dan Sonra ekibinden {$this->sender}");
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
