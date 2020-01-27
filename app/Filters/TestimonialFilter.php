<?php

namespace App\Filters;

use App\Models\Testimonial;
use EnesCakir\Helper\Base\Filter;

class TestimonialFilter extends Filter
{
    protected $filters = ['priority', 'via', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Referanslar_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->name,
                'Metin'       => $item->text,
                'E-posta'     => $item->email,
                'Öncelik'     => $item->priority,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->download($name, $mapper);
    }

}
