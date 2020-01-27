<?php

namespace App\Filters;

use App\Models\Diagnosis;
use EnesCakir\Helper\Base\Filter;

class DiagnosisFilter extends Filter
{
    protected $filters = ['search', 'download'];

    protected function download()
    {
        $name = "LS_Tanı_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->name,
                'Kategory'    => $item->category,
                'Açıklama'    => $item->desc,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }
}