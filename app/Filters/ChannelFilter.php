<?php

namespace App\Filters;

use EnesCakir\Helper\Base\Filter;

class ChannelFilter extends Filter
{
    protected $filters = ['category', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Kanallar_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'           => $item->id,
                'Ad'           => $item->name,
                'Logo'         => $item->logo_url,
                'Kategori'     => $item->category,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }

}
