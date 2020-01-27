<?php

namespace App\Filters;

use App\Models\WishCategory;
use EnesCakir\Helper\Base\Filter;

class WishCategoryFilter extends Filter
{
    protected $filters = ['search', 'download'];

    protected function download()
    {
        $name = "LS_Dilek_Kategorisi_" . date('d_m_Y');
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
