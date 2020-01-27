<?php

namespace App\Filters;

use App\Models\EmailSample;
use EnesCakir\Helper\Base\Filter;

class EmailSampleFilter extends Filter
{
    protected $filters = ['category', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Eposta_Ornekleri_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->name,
                'Kategori'    => $item->category,
                'Metin'       => $item->text,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }
}
