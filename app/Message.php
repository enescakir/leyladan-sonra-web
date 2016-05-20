<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $guarded = [];

    protected $dates = ['answered_at', 'sent_at'];

    public function chat(){
        return $this->belongsTo('App\Chat');
    }

    public function answerer(){
        return $this->belongsTo('App\User', 'answered_by');
    }

    public function sender(){
        return $this->belongsTo('App\User', 'sent_by');
    }

    public function getCreatedAtHumanAttribute($date){
        return date("d.m.Y", strtotime($this->attributes['created_at']));
    }

}
