<?php

namespace App\Filters;

use App\Models\User;

class UserFilter extends Filter
{
    protected $filters = ['approval', 'role_name', 'faculty_id', 'year', 'search', 'download'];


    protected function approval($approval)
    {
        return $this->builder->approved($approval);
    }

    protected function role_name($role)
    {
        $this->builder->role($role)->when($role == 'left', function ($query) {
            return $query->withLefts();
        })->when($role == 'graduated', function ($query) {
            return $query->withGraduateds();
        });
    }

    protected function download()
    {
        $mapper = function ($item, $key) {
            return [
                'ID'           => $item->id,
                'Ad'           => $item->first_name,
                'Soyad'        => $item->last_name,
                'E-posta'      => $item->email,
                'Telefon'      => $item->mobile,
                'Fakülte'      => $item->faculty->name,
                'Görev'        => $item->role_display,
                'Kayıt Tarihi' => $item->created_at,
            ];
        };
        User::download($this->builder, $mapper);
    }
}
