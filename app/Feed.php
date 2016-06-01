<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Feed extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'feeds';

    protected $guarded = [];

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    }

    public function getCreatedAtAttribute(){
        Carbon::setLocale('tr');
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']),'Europe/Istanbul')->diffForHumans();
    }

}
