<?php

namespace App\Enums;

use EnesCakir\Helper\Base\Enum;

class FeedType extends Enum
{
    protected static $descriptions = [
        1 => '[child] ile tanışıldı.',
        2 => '[child] için gönüllü bulundu.',
        3 => '[child] isimli çocuğumuzun hediyesi geldi.',
        4 => '[user], [child] isimli çocuğumuzu sildi.',
        5 => '',
        6 => '[child] isimli çocuğumuzun hediyesi teslim edildi',
        7 => '[child] isimli çocuğumuzun hediye durumu "Bekleniyor" olarak güncellendi',
        8 => '[poll] isimli oylama başlatıldı',
        9 => '[volunteer], [child] için gönüllü oldu.'
    ];

    const ChildCreated = 1;
    const VolunteerFound = 2;
    const GiftArrived = 3;
    const ChildDeleted = 4;
    const Announcement = 5;
    const GiftDelivered = 6;
    const ChildReset = 7;
    const Poll = 8;
    const VolunteerDecided = 9;

    public static function getDescription($value)
    {
        return $value ?
            static::$descriptions[$value] :
            null;
    }
}