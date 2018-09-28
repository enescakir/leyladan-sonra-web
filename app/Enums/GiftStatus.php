<?php

namespace App\Enums;

class GiftStatus extends BaseEnum
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
