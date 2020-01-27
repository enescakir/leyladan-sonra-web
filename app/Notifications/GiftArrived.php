<?php

namespace App\Notifications;

use App\Models\Child;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GiftArrived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $child;

    public function __construct(Child $child)
    {
        $this->child = $child;
    }

    public function via($notifiable)
    {
        return ['mail'];
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

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
