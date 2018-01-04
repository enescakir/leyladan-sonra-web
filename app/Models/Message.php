<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

use Carbon\Carbon;

class Message extends Model
{
    use Base;
    // Properties
    protected $table    = 'messages';
    protected $fillable = ['chat_id', 'text', 'answered_by', 'answered_at', 'sent_by', 'sent_at'];
    protected $appends  = ['is_sent'];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'answered_at', 'sent_at'];

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

    // Accessors
    public function getCreatedAtLabelAttribute()
    {
        return date("d.m.Y", strtotime($this->attributes['created_at']));
    }

    public function getCreatedAtDiffAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']), 'Europe/Istanbul')->diffForHumans();
    }

    public function getIsSentAttribute()
    {
        return $this->attributes['sent_at'] != null;
    }
}
