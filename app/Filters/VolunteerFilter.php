<?php

namespace App\Filters;

use App\Models\Volunteer;
use EnesCakir\Helper\Base\Filter;

class VolunteerFilter extends Filter
{
    protected $filters = ['city', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Gonullu_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->full_name,
                'E-posta'     => $item->email,
                'Telefon'     => $item->mobile,
                'Şehir'       => $item->city,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }

}
