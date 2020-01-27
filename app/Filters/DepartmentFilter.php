<?php

namespace App\Filters;

use App\Models\Department;
use EnesCakir\Helper\Base\Filter;

class DepartmentFilter extends Filter
{
    protected $filters = ['search', 'download'];

    protected function download()
    {
        $name = "LS_Departman_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->name,
                'Açıklama'    => $item->desc,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }
}