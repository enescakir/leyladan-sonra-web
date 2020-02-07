<?php

namespace App\Notifications;

use App\Models\Child;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;

class GiftArrived extends Notification
{
    protected $child;

    public function __construct(Child $child)
    {
        $this->child = $child;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Çocuğunun hediyesi bize ulaştı 🎁')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line("<strong>{$this->child->full_name}</strong> isimli çocuğunun hediyesi fakültene ulaştı.")
            ->line("Çocuğunu fazla bekletmeden hediyesini teslim etmen gerekiyor.")
            ->line("Hediye teslim fotoğrafını ve yazısını sisteme yüklemeyi unutma.")
            ->action('Çocuğu Görüntüle', route('admin.child.show', $this->child->id));
    }

    public function toTelegram($notifiable)
    {
        $message = "*{$this->child->full_name}* isimli çocuğunun hediyesi fakültene ulaştı 🎉 " .
            "Çocuğunu fazla bekletmeden hediyesini teslim etmen gerekiyor. Hediye teslim fotoğrafını ve yazısını sisteme yüklemeyi unutma.";

        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content($message)
            ->animation('https://media.giphy.com/media/14c7Q3pdEOnZN6/giphy.gif')
            ->button('Çocuğu Görüntüle', route('admin.child.show', $this->child->id));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
