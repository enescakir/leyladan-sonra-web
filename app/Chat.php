<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    protected $table = 'chats';

    protected $guarded = [];

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function child(){
        return $this->belongsTo('App\Child');
    }

    public function volunteer(){
        return $this->belongsTo('App\Volunteer');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function avgTime(){
        $messages = $this->messages;
        $sum = 0;
        $counter = 0;

        foreach( $messages as $message){
            if( $message->sent_at == null){
                $counter += 1;
                if( $message->answered_at == null){
                    $sum += $message->created_at->diffInMinutes(Carbon::now());
                }
                else{
                    $sum += $message->created_at->diffInMinutes($message->answered_at);
                }
            }
        }
        if($counter == 0)
            return 0;
        return $sum / $counter / 60;
    }


    public function scopeOpen($query){
        $query->where('status', 'Açık');
    }
}
