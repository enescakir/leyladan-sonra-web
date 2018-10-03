<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use App\Traits\HasMobile;

class Blood extends Model
{
    use BaseActions;
    use HasMobile;
    use Filterable;
    use Downloadable;

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
