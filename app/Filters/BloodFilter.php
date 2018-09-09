<?php

namespace App\Filters;

use App\Models\Blood;

class BloodFilter extends Filter
{
    protected $filters = ['blood_type', 'rh', 'city', 'search', 'download'];


    protected function download()
    {
        Blood::download($this->builder);
    }
}
