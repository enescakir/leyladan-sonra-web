<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;

class Process extends Model
{
    use BaseActions;
    // Properties
    protected $table    = 'processes';
    protected $fillable = ['child_id', 'desc', 'type', 'processable_id', 'processable_type'];

    // Relations
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function processable()
    {
        return $this->morphTo();
    }

}
