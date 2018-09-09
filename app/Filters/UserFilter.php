<?php

namespace App\Filters;

use App\Models\User;

class UserFilter extends Filter
{
    protected $filters = ['approval', 'role_name', 'faculty_id', 'search', 'download'];

    protected function faculty_id($faculty_id)
    {
        return $this->builder->where('faculty_id', $faculty_id);
    }

    protected function approval($approval)
    {
        return $this->builder->Approved($approval);
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
