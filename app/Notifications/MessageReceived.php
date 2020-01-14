<?php

namespace App\Notifications;

use App\Models\Chat;
use App\Models\Child;
use App\Models\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MessageReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $child;
    protected $volunteer;
    protected $chat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Child $child, Volunteer $volunteer, Chat $chat)
    {
        $this->child = $child;
        $this->volunteer = $volunteer;
        $this->chat = $chat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Gönüllümüzden yeni mesaj var! 📫')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line("<strong>{$this->child->full_name}</strong> isimli çocuğumuz için <strong>{$this->volunteer->full_name}</strong> isimli gönüllüden mesaj var.")
            ->line("Sisteme giriş yaparak '<em>Gönüllüler > Aktif Sohbetler</em>' sayfasından mesajı görüntüleyebilirsin.")
            ->line("Eğer başka bir arkadaşın cevaplamadıysa mesajın üstüne gelerek 'Cevapladım' butonuna tıkla ve fakülte e-posta adresinden gönüllüyle iletişime geç.")
            ->line("Çocuğumuzun hediyesine bir an önce kavuşabilmesi için mesajı cevaplaman gerekiyor.")
            ->action('Mesajı Görüntüle', route('admin.faculty.chat.index', ['faculty' => $this->child->faculty->id, 'chat_id' => $this->chat->id, 'child_id' => $this->child->id]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
