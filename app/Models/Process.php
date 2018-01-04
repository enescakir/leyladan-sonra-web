<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Process extends Model
{
    use Base;
    // Properties
    protected $table    = 'processes';
    protected $fillable = ['child_id', 'desc'];

    // Relations
    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
