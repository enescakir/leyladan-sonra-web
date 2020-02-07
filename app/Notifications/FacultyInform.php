<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

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

    public function toTelegram($notifiable)
    {
        $message = "*{$this->subject}* \n" .
            "Merhaba {$notifiable->first_name}, \n" .
            "{$this->body} \n\n" .
            "_Leyla'dan Sonra ekibinden {$this->sender}_";

        return TelegramMessage::create()
            ->to($notifiable->telegram_user_id)
            ->content($message);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
