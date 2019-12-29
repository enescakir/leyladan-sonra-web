<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Downloadable;
use EnesCakir\Helper\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use BaseActions;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'questions';
    protected $fillable = ['text', 'answer', 'order'];

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('text', 'like', '%' . $search . '%')->orWhere('answer', 'like', '%' . $search . '%');
        });
    }
}
