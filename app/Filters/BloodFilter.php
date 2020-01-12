<?php

namespace App\Filters;

use EnesCakir\Helper\Base\Filter;

class BloodFilter extends Filter
{
    protected $filters = ['blood_type', 'rh', 'city', 'search', 'download'];

    protected function download()
    {
        $name = "LS_KanBagiscisi_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'           => $item->id,
                'Telefon'      => $item->mobile,
                'Grup'         => $item->blood_type,
                'RH'           => $item->rh,
                'Şehir'        => $item->city,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }
}
