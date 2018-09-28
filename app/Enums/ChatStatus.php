<?php

namespace App\Enums;

class ChatStatus extends BaseEnum
{
    const Open = 'Açık';
    const Answered = 'Cevaplandı';
    const Closed = 'Kapalı';

    protected static $statusTexts = [
        'Açık'       => 'Açık',
        'Cevaplandı' => 'Cevaplandı',
        'Kapalı'     => 'Kapalı'
    ];

    public static function actives()
    {
        return [static::Open, static::Answered];
    }
}
