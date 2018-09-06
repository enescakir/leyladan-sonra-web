<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Filters\Filter;

trait Filterable
{
    public function scopeFilter($query, Filter $filter)
    {
        return $filter->apply($query);
    }
}
