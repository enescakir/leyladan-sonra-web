<?php

namespace App\Models;

use EnesCakir\Helper\Traits\Approvable;
use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Downloadable;
use EnesCakir\Helper\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use BaseActions;
    use Approvable;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'testimonials';
    protected $fillable = ['name', 'text', 'email', 'via', 'priority', 'approved_at', 'approved_by'];
    protected $dates = ['approved_at'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', "%{$search}%")
                ->orWhere('text', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Global Methods
    public static function toSourceSelect($placeholder = null)
    {
        $result = static::orderBy('via')->pluck('via', 'via');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }
}
