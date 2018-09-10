<?php

namespace App\Filters;

use App\Models\Blood;

class BloodFilter extends Filter
{
    protected $filters = ['blood_type', 'rh', 'city', 'search', 'per_page', 'download'];


    protected function download()
    {
        Blood::download($this->builder);
    }
}
