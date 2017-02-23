<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $table = 'messages';

    protected $guarded = [];
    protected $appends = ['is_sent'];
    protected $dates = ['answered_at', 'sent_at'];

    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }

    public function answerer()
    {
        return $this->belongsTo('App\User', 'answered_by');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sent_by');
    }

    public function getCreatedAtLabelAttribute(){
        return date("d.m.Y", strtotime($this->attributes['created_at']));
    }

    public function getCreatedAtDiff(){
        Carbon::setLocale('tr');
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']),'Europe/Istanbul')->diffForHumans();
    }


    public function getIsSentAttribute(){
        return $this->attributes['sent_at'] != null;
    }

}
