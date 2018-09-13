<?php

namespace App\Enums;

class PostType extends BaseEnum
{

    protected static $statusTexts = [
        'Tanışma' => 'Tanışma',
        'Hediye'  => 'Hediye'
    ];

    const Meeting = 'Tanışma';
    const Delivery = 'Hediye';
}
