<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use BaseActions;

    // Properties
    protected $table = 'post_images';
    protected $fillable = ['name', 'ratio', 'post_id'];

    // Relations
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Scopes
    public function scopeRatio($query, $ratio)
    {
        $query->where('ratio', $ratio);
    }

    // Getters
    public function getPathAttribute()
    {
        return asset(upload_path("child", $this->name));
    }
}
