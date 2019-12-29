<?php

namespace App\Filters;

use App\Models\Diagnosis;
use EnesCakir\Helper\Base\Filter;

class DiagnosisFilter extends Filter
{
    protected $filters = ['search', 'download'];

    protected function download()
    {
        Diagnosis::download($this->builder);
    }
}