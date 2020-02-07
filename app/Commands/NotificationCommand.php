<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\ChatAction;
use Auth;

class NotificationCommand extends UserCommand
{
    protected $name = 'notification';
    protected $usage = '/notification [E-POSTA] [ŞİFRE]';
    protected $description = 'Telegram bildirimleri için kayıt olun';
    protected $version = '1.0.0';

    public function execute()
    {
        $message = $this->getMessage();
        $chatID = $message->getChat()->getId();
        $messageID = $message->getMessageId();

        $this->replyToUser("Bilgilerinin doğruluğu kontrol ediliyor 🔐");

        Request::sendChatAction([
            'chat_id' => $chatID,
            'action'  => ChatAction::TYPING,
        ]);

        $args = explode(" ", $message->getText(true));

        if (count($args) < 2) {
            $this->replyToUser("Komutu yanlış kullandın ‼️");
            $this->replyToUser("Doğru kullanımı aşağıdaki gibidir 👇");
            $this->replyToUser("`{$this->usage}`", ['parse_mode' => 'MARKDOWN']);

            return Request::emptyResponse();
        }

        $email = $args[0];
        $password = $args[1];

        Request::deleteMessage([
            'chat_id'    => $chatID,
            'message_id' => $messageID,
        ]);


        if (!Auth::once(['email' => $email, 'password' => $password])) {
            $this->replyToUser("Bu kriterlerlere uygun kullanıcı bulamadım 😪");

            return Request::emptyResponse();
        }

        $user = auth()->user();

        $user->update(['telegram_user_id' => $chatID]);

        $this->replyToUser("Hoş geldin {$user->first_name} 🎉");
        $this->replyToUser("Bundan böyle sistemden gelen bildirimleri e-posta yerine benden alacaksın 💌");
        $this->replyToUser("`/stop` yazarak benden bildirim almayı bırakabilirsin", ['parse_mode' => 'MARKDOWN']);

        return Request::emptyResponse();
    }
}