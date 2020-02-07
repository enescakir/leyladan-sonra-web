<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class RegisterCommand extends UserCommand
{
    protected $name = 'kayit';
    protected $usage = '/kayit';
    protected $description = 'Telegram bildirimleri için kayıt olun';
    protected $version = '1.0.0';

    public function execute()
    {
        \Log::info("RegisterCommand");
//        $this->replyWithMessage(['text' => 'Bilgilerinizin doğruluğu kontrol ediliyor 🔐']);
//
//        $this->replyWithChatAction(['action' => Actions::TYPING]);
//
//        $args = explode('', $arguments);
//
//        if (count($args) < 2) {
//        }
//
//        $this->replyWithMessage(['text' => "Naber"]);

//        -----
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => 'This is just a Test...', // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
}