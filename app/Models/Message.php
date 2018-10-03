<?php

namespace App\Models;

use App\Enums\ChatStatus;
use Illuminate\Database\Eloquent\Model;
use Auth;

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
    public function scopeSent($query, $sent = true)
    {
        return $sent
            ? $query->whereNotNull('sent_by')
            : $query->whereNull('sent_by');
    }

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
        return $this->attributes['sent_by'] != null;
    }

    public function getIsAnsweredAttribute()
    {
        return $this->attributes['answered_at'] != null;
    }

    public function getAnswerTimeAttribute()
    {
        return $this->created_at->diffInMinutes($this->isAnswered
            ? $this->answered_at
            : now()
        );
    }

    // Method
    public function answer()
    {
        $this->answerer()->associate(Auth::user());
        $this->answered_at = now();
        $this->save();
    }
}
