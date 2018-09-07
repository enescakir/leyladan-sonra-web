<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BaseActions;

class BlogCategory extends Model
{
    use BaseActions;
    // Properties
    protected $table    = 'blog_categories';
    protected $fillable = ['title', 'slug', 'desc'];
    protected $slugKeys = ['title'];

    // Relations
    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_category', 'category_id', 'blog_id')->withTimestamps();
    }
}
