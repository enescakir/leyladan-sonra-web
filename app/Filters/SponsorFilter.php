<?php

namespace App\Filters;

use App\Models\Sponsor;
use EnesCakir\Helper\Base\Filter;

class SponsorFilter extends Filter
{
    protected $filters = ['order', 'search', 'download'];

    protected function download()
    {
        $name = "LS_DestekVerenler_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->name,
                'Bağlantı'    => $item->link,
                'Logo'        => $item->logo_url,
                'Sıralama'    => $item->order,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }

}
