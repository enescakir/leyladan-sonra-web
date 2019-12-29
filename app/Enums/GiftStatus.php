<?php

namespace App\Enums;

use EnesCakir\Helper\Base\Enum;

class GiftStatus extends Enum
{
    const Waiting = 'Bekleniyor';
    const OnRoad = 'Yolda';
    const Arrived = 'Bize Ulaştı';
    const Delivered = 'Teslim Edildi';

    protected static $statusTexts = [
        'Bekleniyor'    => 'Bekleniyor',
        'Yolda'         => 'Yolda',
        'Bize Ulaştı'   => 'Bize Ulaştı',
        'Teslim Edildi' => 'Teslim Edildi',
    ];

}
