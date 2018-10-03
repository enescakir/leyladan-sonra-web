<?php

namespace App\Enums;

class ProcessType extends BaseEnum
{
    protected static $statusTexts = [
        1  => 'Çocuk sisteme girildi',
        2  => 'Çocuğun yazısı onaylandı',
        3  => 'Çocuğun yazısının onayı kaldırıldı',
        4  => 'Gönüllü bulundu',
        5  => '* gönüllü olarak belirlendi',
        6  => 'Hediyesi bize ulaştı',
        7  => 'Hediyesi teslim edildi',
        8  => 'Ziyaret edildi',
        9  => 'Çocuk sistemden silindi',
        10 => 'Hediye durumu "Bekleniyor" olarak güncellendi',
    ];

    const Created = 1;
    const PostApproved = 2;
    const PostUnapproved = 3;
    const VolunteerFound = 4;
    const VolunteerDecided = 5;
    const GiftArrived = 6;
    const GiftDelivered = 7;
    const Visit = 8;
    const Deleted = 9;
    const Reset = 10;
}