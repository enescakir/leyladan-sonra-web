<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use App\Traits\Approvable;

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

    // Validation rules
    public static $rules = [
        'name'     => 'required|max:255',
        'text'     => 'required',
        'via'      => 'required',
        'priority' => 'required|numeric'
    ];

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
