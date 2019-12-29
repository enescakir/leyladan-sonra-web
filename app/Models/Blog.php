<?php

namespace App\Models;

use EnesCakir\Helper\Traits\BaseActions;
use Illuminate\Database\Eloquent\Model;


class Blog extends Model
{
    use BaseActions;

    // Properties
    protected $table = 'blogs';
    protected $fillable = ['title', 'text', 'thumb', 'slug', 'type', 'link'];
    protected $slugKeys = ['title', 'id'];

    // Validation rules
    public static $createRules = [
        'title'      => 'required|max:255',
        'categories' => 'required',
        'thumb'      => 'image',
        'type'       => 'required',
    ];

    // Relations
    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category', 'blog_id', 'category_id')->withTimestamps();
    }

    // Mutators
    public function setTextAttribute($text)
    {
        return $this->attributes['text'] = clean_text($text);
    }
}
