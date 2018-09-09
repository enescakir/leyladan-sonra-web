<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;

class News extends Model
{
    use BaseActions;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'news';
    protected $fillable = ['title', 'desc', 'link', 'channel_id'];

    // Relations
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('title', 'like', '%' . $search . '%')
                    ->orWhere('desc', 'like', '%' . $search . '%');
        });
    }
}
