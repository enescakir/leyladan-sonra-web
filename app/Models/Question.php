<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;

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
