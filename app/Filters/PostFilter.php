<?php

namespace App\Filters;

use App\Models\Post;
use EnesCakir\Helper\Base\Filter;

class PostFilter extends Filter
{
    protected $filters = ['faculty_id', 'type', 'approval', 'search', 'download'];

    protected function faculty_id($faculty_id)
    {
        return $this->builder->faculty($faculty_id);
    }

    protected function approval($approval)
    {
        return $this->builder->approved($approval);
    }

    protected function download()
    {
        $name = "LS_Yazi_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Çocuk'       => $item->child->full_name,
                'Tip'         => $item->type,
                'Metin'       => $item->text,
                'Onay'        => $item->approved_at,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->with('child')->download($name, $mapper);
    }

}
