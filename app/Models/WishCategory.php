<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class WishCategory extends Model
{
    use BaseActions;
    use Filterable;

    // Properties
    protected $table = 'wish_categories';
    protected $fillable = ['name', 'desc'];

    // Relations
    public function children()
    {
        return $this->hasMany(Child::class);
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function toSelect($placeholder = null)
    {
        $result = static::orderBy('name')->pluck('name', 'id');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }

}
