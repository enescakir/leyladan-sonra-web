<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Message extends Model
{
    // Properties
    protected $table = 'messages';
    protected $fillable = ['chat_id', 'text', 'answered_by', 'answered_at', 'sent_by'];
    protected $appends = ['is_sent'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'answered_at'];

    // Relations
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function answerer()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    // Scopes
    public function scopeAnswered($query, $answer = true)
    {
        return $answer
            ? $query->whereNotNull('answered_at')
            : $query->whereNull('answered_at');
    }

    // Accessors
    public function getCreatedAtLabelAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['created_at']));
    }


    public function getIsSentAttribute()
    {
        return $this->attributes['sent_at'] != null;
    }
}
