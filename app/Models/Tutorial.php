<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;

class Tutorial extends Model
{
    use BaseActions;
    use Filterable;

    // Properties
    protected $table = 'tutorials';
    protected $fillable = [
        'name', 'category', 'link'
    ];

    // Scopes
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                        ->orWhere('link', 'like', '%' . $search . '%');
        });
    }

    // Helpers
    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
