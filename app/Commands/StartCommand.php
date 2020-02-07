<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class StartCommand extends UserCommand
{
    protected $name = 'start';
    protected $usage = '/start';
    protected $description = 'Telegram botunu başlatın';
    protected $version = '1.0.0';

    public function execute()
    {
        $this->replyToUser("Merhabalar 👋");
        $this->replyToUser("Ben Leyla'dan Sonra Botu 😇");
        $this->replyToUser("`/notification [E-POSTA] [ŞİFRE]` komutu ile sistemden gelen bildirimleri almaya başlayabilirsin 📣", ['parse_mode' => 'MARKDOWN']);

        return Request::emptyResponse();
    }

}