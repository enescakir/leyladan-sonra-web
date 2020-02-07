<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class FacultyInform extends Notification
{
    protected $sender;
    protected $subject;
    protected $body;

    public function __construct($subject, $body, $sender)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->sender = $sender;
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
