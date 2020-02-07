<?php

namespace App\Http\Controllers\Admin\Miscellaneous;

use App\Http\Controllers\Controller;
use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'webhook']);
    }

    public function webhook(PhpTelegramBotContract $telegramBot)
    {
        $telegramBot->handle();
    }

    public function set(PhpTelegramBotContract $telegramBot)
    {
        $telegramBot->setWebhook(route('admin.telegram.webhook'));

        return api_success();
    }
}