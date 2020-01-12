<?php

namespace App\Filters;

use EnesCakir\Helper\Base\Filter;

class QuestionFilter extends Filter
{
    protected $filters = ['order', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Soru_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Soru'        => $item->text,
                'Cevap'       => $item->answer,
                'Sıralama'    => $item->order,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }

}
