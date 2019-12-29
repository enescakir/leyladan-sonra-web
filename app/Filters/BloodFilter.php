<?php

namespace App\Filters;

use App\Models\Blood;
use EnesCakir\Helper\Base\Filter;

class BloodFilter extends Filter
{
    protected $filters = ['blood_type', 'rh', 'city', 'search', 'download'];


    protected function download()
    {
        Blood::download($this->builder);
    }
}
