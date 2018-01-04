<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;

class News extends Model
{
    use Base;
    protected $table    = 'news';
    protected $fillable = ['title', 'desc', 'link', 'channel_id'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
