<?php

namespace App\Filters;

use App\Models\Sms;
use EnesCakir\Helper\Base\Filter;

class SmsFilter extends Filter
{
    protected $filters = ['sent_by', 'search', 'download'];


    protected function download()
    {
        $name = "LS_SMS_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'           => $item->id,
                'Başlık'       => $item->title,
                'Mesaj'        => $item->message,
                'Kategori'     => $item->category,
                'Alıcı Sayıcı' => $item->receiver_count,
                'Gönderen'     => $item->sender->full_name,
                'Oluşturulma'  => $item->created_at,
            ];
        };

        $this->builder->with('sender')->download($name, $mapper);
    }

}
