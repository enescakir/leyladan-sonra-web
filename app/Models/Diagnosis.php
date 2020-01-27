<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Excel;

class Diagnosis extends Model
{
    use BaseActions;
    use Filterable;

    // Properties
    protected $table = 'diagnoses';
    protected $fillable = ['name', 'category', 'desc'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                ->orWhere('desc', 'like', '%' . $search . '%');
        });
    }
}
