<?php

namespace App\Filters;

use App\Models\EmailSample;

class EmailSampleFilter extends Filter
{
    protected $filters = ['category', 'search', 'download'];

    protected function download()
    {
        EmailSample::download($this->builder);
    }
}
