<?php

namespace App\Notifications;

use App\Models\Chat;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramFile;

class MessageReceived extends Notification
{
    protected $child;
    protected $volunteer;
    protected $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
        $this->child = $chat->child;
        $this->volunteer = $chat->volunteer;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Gönüllüden yeni mesaj var! 📫')
            ->greeting("Merhaba {$notifiable->first_name},")
            ->line("<strong>{$this->child->full_name}</strong> isimli çocuğumuz için <strong>{$this->volunteer->full_name}</strong> isimli gönüllüden mesaj var.")
            ->line("Sisteme giriş yaparak '<em>Gönüllüler > Aktif Sohbetler</em>' sayfasından mesajı görüntüleyebilirsin.")
            ->line("Eğer başka bir arkadaşın cevaplamadıysa mesajın üstüne gelerek 'Cevapladım' butonuna tıkla ve fakülte e-posta adresinden gönüllüyle iletişime geç.")
            ->line("Çocuğumuzun hediyesine bir an önce kavuşabilmesi için mesajı cevaplaman gerekiyor.")
            ->action('Mesajı Görüntüle', route('admin.faculty.chat.index', ['faculty' => $this->child->faculty->id, 'chat_id' => $this->chat->id, 'child_id' => $this->child->id]));
    }

    public function toTelegram($notifiable)
    {
        $message = "*{$this->child->full_name}* isimli çocuğumuz için *{$this->volunteer->full_name}* isimli gönüllüden mesaj var 📫 " .
            "Eğer mesaj cevaplanmadıysa mesajın üstüne gelerek `Cevapladım` butonuna tıkla ve fakülte e-posta adresinden gönüllüyle iletişime geç. " .
            "Çocuğumuzun hediyesine bir an önce kavuşabilmesi için mesajı cevaplaman gerekiyor.";

        return TelegramFile::create()
            ->to($notifiable->telegram_user_id)
            ->content($message)
            ->animation('https://media.giphy.com/media/mPOGx4hJtOWSA/giphy.gif')
            ->button('Mesajı Görüntüle', route('admin.faculty.chat.index', ['faculty' => $this->child->faculty->id, 'chat_id' => $this->chat->id, 'child_id' => $this->child->id]));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
