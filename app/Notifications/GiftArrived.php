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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Child $child)
    {
        $this->child = $child;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Çocuğunuzun hediyesi bize ulaştı 🎁')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line("{$this->child->full_name} isimli çocuğumuzun hediyesi fakültemize ulaştı.")
            ->line("Çocuğumuzu fazla bekletmeden hediyesini teslim etmeniz gerekiyor.")
            ->line("Hediye teslim fotoğrafını ve yazısını sisteme yüklemeyi unutmayın.")
            ->action('Çocuğu Görüntüle', route('admin.child.show', $this->child->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
