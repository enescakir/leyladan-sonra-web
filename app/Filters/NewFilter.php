<?php

namespace App\Filters;

use EnesCakir\Helper\Base\Filter;

class NewFilter extends Filter
{
    protected $filters = ['channel_id', 'search', 'download'];

    protected function download()
    {
        $name = "LS_Haber_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Başlık'      => $item->title,
                'Açıklama'    => $item->desc,
                'Kanal'       => $item->channel->name,
                'Bağlantı'    => $item->link,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->with('channel')->download($name, $mapper);
    }

}
