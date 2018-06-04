<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    // Methods
    public static function toSelect($placeholder = null, $public = true)
    {
        $result = static::orderBy('display')->when(!is_null($public), function ($query) use ($public) {
            $query->where('public', $public);
        })->pluck('display', 'id');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
