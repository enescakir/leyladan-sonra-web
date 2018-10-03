<?php

namespace App\Models;

use App\Enums\ProcessType;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;

class Process extends Model
{
    use BaseActions;
    // Properties
    protected $table = 'processes';
    protected $fillable = ['child_id', 'desc', 'type', 'processable_id', 'processable_type'];
    protected $appends = ['text'];

    // Relations
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function processable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    // Accessors
    public function getTextAttribute()
    {
        $text = ProcessType::getText($this->type);
        if ($this->processable) {
            $text = str_replace('*', $this->processable->full_name, $text);
        }
        return $text;
    }
}
