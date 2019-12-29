<?php

namespace App\Filters;

use App\Models\Faculty;
use EnesCakir\Helper\Base\Filter;

class FacultyFilter extends Filter
{
    protected $filters = ['started', 'city', 'search', 'download'];

    protected function download()
    {
        Faculty::download($this->builder);
    }
}
