<?php

namespace App\Notifications;

use App\Models\Child;
use Illuminate\Notifications\Messages\MailMessage;

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

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
