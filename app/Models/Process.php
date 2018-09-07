<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;

class Process extends Model
{
    use BaseActions;
    // Properties
    protected $table    = 'processes';
    protected $fillable = ['child_id', 'desc'];

    // Relations
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
