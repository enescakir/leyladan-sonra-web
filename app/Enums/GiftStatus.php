<?php

namespace App\Enums;

// TODO: Complete chat status
class GiftStatus extends BaseEnum
{
  const Waiting   = 'Bekleniyor';
  const OnRoad    = 'Yolda';
  const Arrived   = 'Bize Ulaştı';
  const Delivered = 'Teslim Edildi';
}
