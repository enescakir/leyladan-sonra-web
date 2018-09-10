<?php

namespace App\Filters;

use App\Models\Faculty;

class FacultyFilter extends Filter
{
    protected $filters = ['started', 'city', 'search', 'per_page', 'download'];

    protected function download()
    {
        Faculty::download($this->builder);
    }
}
