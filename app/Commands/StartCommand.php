<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Spatie\Emoji\Emoji;

class StartCommand extends UserCommand
{
    protected $name = 'start';
    protected $usage = '/start';
    protected $description = 'Telegram botunu başlatın';
    protected $version = '1.0.0';

    public function execute()
    {

        $this->replyToUser("Merhabalar " . Emoji::wavingHand());
        $this->replyToUser("Ben Leyla'dan Sonra Botu " . Emoji::smilingFaceWithHalo());
        $this->replyToUser("`/notification [E-POSTA] [ŞİFRE]` komutu ile sistemden gelen bildirimleri almaya başlayabilirsin " . Emoji::megaphone(), ['parse_mode' => 'MARKDOWN']);

        return Request::emptyResponse();
    }

}