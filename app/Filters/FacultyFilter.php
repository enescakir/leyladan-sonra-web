<?php

namespace App\Filters;

use App\Models\Faculty;
use EnesCakir\Helper\Base\Filter;

class FacultyFilter extends Filter
{
    protected $filters = ['started', 'city', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Fakulte_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->name,
                'Kısaltma'    => $item->slug,
                'Şehir'       => $item->city,
                'Başlama'     => $item->started_at,
                'Logo'        => $item->logo_url,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }
}
