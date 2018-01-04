<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class Channel extends Model
{
    use Base;
    // Properties
    protected $table    = 'channels';
    protected $fillable = ['name', 'logo', 'category'];

    // Relations
    public function news()
    {
        return $this->hasMany(News::class);
    }

    // Global Methods
    public static function toSelect($empty = false)
    {
        $res = Channel::orderBy('name')->pluck('name', 'id');
        return $empty ? collect(['' => ''])->merge($res) : $res;
    }
}
