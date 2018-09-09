<?php

namespace App\Filters;

use App\Models\Sponsor;

class SponsorFilter extends Filter
{
    protected $filters = ['order', 'search', 'download'];

    protected function download()
    {
        $mapper = function ($item) {
            $item->logo = $item->logo_url;
            return $item;
        };

        Sponsor::download($this->builder, $mapper);
    }

}
