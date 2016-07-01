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

    public function getIconAttribute(){
        $icon = $this->attributes['icon'];
        $iconText = "";
        switch ($icon) {
            case "1":
                $iconText = '<div class="label label-sm label-warning"> <i class="fa fa-child"></i></div>';
                break;
            case "2":
                $iconText = '<div class="label label-sm label-info"> <i class="fa fa-male"></i></div>';
                break;
            case "3":
                $iconText = '<div class="label label-sm label-success"> <i class="fa fa-gift"></i></div>';
                break;
            case "4":
                $iconText = '<div class="label label-sm label-danger"> <i class="fa fa-trash"></i></div>';
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }

        return $iconText;
    }

}
