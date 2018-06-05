<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Base;

class Tutorial extends Model
{
    use Base;

    // Properties
    protected $table = 'tutorials';
    protected $fillable = [
        'name', 'category', 'link'
    ];

    // Helpers
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                        ->orWhere('link', 'like', '%' . $search . '%');
        });
    }

    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder ? collect(['' => $placeholder])->union($result) : $result;
    }
}
