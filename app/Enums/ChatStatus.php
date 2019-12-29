<?php

namespace App\Enums;

use EnesCakir\Helper\Base\Enum;

class ChatStatus extends Enum
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
