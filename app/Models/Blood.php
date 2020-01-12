<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Filterable;
use EnesCakir\Helper\Traits\HasMobile;
use Illuminate\Database\Eloquent\Model;

class Blood extends Model
{
    use BaseActions;
    use HasMobile;
    use Filterable;

    // Properties
    protected $table = 'bloods';
    protected $fillable = ['rh', 'mobile', 'city', 'blood_type'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('id', $search)
                ->orWhere('mobile', 'like', '%' . $search . '%')
                ->orWhere('city', 'like', '%' . $search . '%');
        });
    }

    // Accessors
    public function getRhLabelAttribute()
    {
        return $this->attributes['rh'] == 1
            ? 'Pozitif'
            : 'Negatif';
    }
}
