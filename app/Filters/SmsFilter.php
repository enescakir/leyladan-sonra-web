<?php

namespace App\Filters;

use App\Models\Sms;

class SmsFilter extends Filter
{
    protected $filters = ['sent_by', 'search', 'download'];


    protected function download()
    {
        Sms::download($this->builder);
    }
}
