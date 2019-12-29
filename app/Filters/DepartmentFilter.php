<?php

namespace App\Filters;

use App\Models\Department;
use EnesCakir\Helper\Base\Filter;

class DepartmentFilter extends Filter
{
    protected $filters = ['search', 'download'];

    protected function download()
    {
        Department::download($this->builder);
    }
}