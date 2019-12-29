<?php

namespace App\Filters;

use App\Models\Sms;
use EnesCakir\Helper\Base\Filter;

class SmsFilter extends Filter
{
    protected $filters = ['sent_by', 'search', 'download'];


    protected function download()
    {
        Sms::download($this->builder);
    }
}
