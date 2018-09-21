<?php

namespace App\Filters;

use App\Models\Volunteer;

class VolunteerFilter extends Filter
{
    protected $filters = ['city', 'search', 'download'];


    protected function download()
    {
        Volunteer::download($this->builder);
    }
}
