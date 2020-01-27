<?php

namespace App\Filters;

use App\Models\User;
use EnesCakir\Helper\Base\Filter;

class UserFilter extends Filter
{
    protected $filters = ['approval', 'role_name', 'faculty_id', 'year', 'search', 'download'];

    protected function approval($approval)
    {
        return $this->builder->approved($approval);
    }


    protected function roleName($role)
    {
        $this->builder->role($role);
    }

    protected function download()
    {
        $name = "LS_Uyeler_" . date('d_m_Y');
        $mapper = function ($item, $key) {
            return [
                'ID'          => $item->id,
                'Ad'          => $item->first_name,
                'Soyad'       => $item->last_name,
                'E-posta'     => $item->email,
                'Telefon'     => $item->mobile,
                'Fakülte'     => $item->faculty->name,
                'Görev'       => $item->role_display,
                'Oluşturulma' => $item->created_at,
            ];
        };

        $this->builder->with('faculty')->download($name, $mapper);
    }

}
