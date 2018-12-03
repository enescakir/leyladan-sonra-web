<?php

namespace App\Filters;

use App\Models\WishCategory;

class WishCategoryFilter extends Filter
{
    protected $filters = ['search', 'download'];

    protected function download()
    {
        WishCategory::download($this->builder);
    }
}
