<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use App\Models\User;
use Spatie\Emoji\Emoji;

class StopCommand extends UserCommand
{
    protected $name = 'stop';
    protected $usage = '/stop';
    protected $description = 'Telegram botunu durdurun';
    protected $version = '1.0.0';

    public function execute()
    {
        $chatID = $this->getMessage()->getChat()->getId();
        User::where('telegram_user_id', $chatID)->update(['telegram_user_id' => null]);

        $this->replyToUser("Benden artık bildirim almayacaksın " . Emoji::sleepyFace());
        $this->replyToUser("Güle güle " . Emoji::wavingHand());
        $this->replyToUser("`/notification [E-POSTA] [ŞİFRE]` komutu ile sistemden gelen bildirimleri almaya yeniden başlayabilirsin " . Emoji::megaphone(), ['parse_mode' => 'MARKDOWN']);

        return Request::emptyResponse();
    }

}