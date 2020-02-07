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

        $this->replyToUser("Merhabalar " . Emoji::CHARACTER_WAVING_HAND);
        $this->replyToUser("Ben Leyla'dan Sonra Botu " . Emoji::CHARACTER_SMILING_FACE_WITH_HALO);
        $this->replyToUser("`/notification [E-POSTA] [ŞİFRE]` komutu ile sistemden gelen bildirimleri almaya başlayabilirsin " . Emoji::CHARACTER_MEGAPHONE, ['parse_mode' => 'MARKDOWN']);

        return Request::emptyResponse();
    }

}