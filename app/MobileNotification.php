<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class MobileNotification extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'expected_at', 'sent_at'];

    public static function boot() {
        parent::boot();

        // create a event to happen on updating
        static::updating(function($table)  {
            $table->updated_by = Auth::user()->id;
        });

        // create a event to happen on deleting
        static::deleting(function($table)  {
            $table->deleted_by = Auth::user()->id;
            $table->save();
        });

        // create a event to happen on saving
        static::creating(function($table)  {
            $table->created_by = Auth::user()->id;
        });
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
