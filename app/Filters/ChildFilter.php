<?php

namespace App\Filters;

use App\Models\Child;
use EnesCakir\Helper\Base\Filter;

class ChildFilter extends Filter
{
    protected $filters = ['faculty_id', 'department', 'diagnosis', 'gift_state', 'search', 'until', 'download'];

    protected function faculty_id($faculty_id)
    {
        return $this->builder->where('faculty_id', $faculty_id);
    }

    protected function until($until)
    {
        return $until
            ? $this->builder->whereDate('until', '>=', now())
            : $this->builder->whereDate('until', '<', now());
    }

    protected function download()
    {
        $name = "LS_Cocuk_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->first_name,
                'Soyad'       => $item->last_name,
                'Fakülte'     => $item->faculty->name,
                'Tanışma'     => $item->meeting_day,
                'Doğum Günü'  => $item->birthday,
                'Tanı'        => $item->diagnosis,
                'Dilek'       => $item->wish,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->with('faculty')->download($name, $mapper);
    }
}
