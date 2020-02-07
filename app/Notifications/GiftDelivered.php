<?php

namespace App\Notifications;

use App\Models\Child;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;

class GiftDelivered extends Notification
{
    protected $child;

    public function __construct(Child $child)
    {
        $this->child = $child;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Çocuğumuzun hediyesi teslim edildi 🎈')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line("<strong>{$this->child->full_name}</strong> isimli çocuğumuzun hediyesi teslim edildi.")
            ->line("Dileği gerçekleştiren gönüllümüze teşekkür edebilirsin.")
            ->action('Yazıyı Görüntüle', route('front.child', [$this->child->faculty->slug, $this->child->slug]));
    }

    public function toTelegram($notifiable)
    {
        $message = "*{$this->child->full_name}* isimli çocuğumuzun hediyesi teslim edildi 🎈 Dileği gerçekleştiren gönüllümüze teşekkür edebilirsin";

        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content($message)
            ->animation('https://media.giphy.com/media/n2IekUAIvjz2w/giphy.gif')
            ->button('Yazıyı Görüntüle', route('front.child', [$this->child->faculty->slug, $this->child->slug]));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
