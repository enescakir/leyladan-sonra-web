<?php

namespace App\Filters;

use App\Models\Volunteer;
use EnesCakir\Helper\Base\Filter;

class VolunteerFilter extends Filter
{
    protected $filters = ['city', 'search', 'download'];


    protected function download()
    {
        Volunteer::download($this->builder);
    }
}
