<?php

namespace App\Enums;

use EnesCakir\Helper\Base\Enum;

class PostType extends Enum
{

    protected static $statusTexts = [
        'Tanışma' => 'Tanışma',
        'Hediye'  => 'Hediye'
    ];

    const Meeting = 'Tanışma';
    const Delivery = 'Hediye';
}
