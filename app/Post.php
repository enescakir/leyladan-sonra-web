<?php

namespace App;

class Post extends BaseModel
{
    protected $table = 'posts';
    protected $guarded = [];

    public function child()
    {
        return $this->belongsTo('App\Child');
    }

    public function images()
    {
        return $this->hasMany('App\PostImage');
    }

    public function scopeMeetingPost($query, $id)
    {
        $query->where('type', 'Tanışma')->where('child_id', $id);
    }

    public function scopeApproved($query)
    {
        $query->whereNotNull('approved_at');
    }

    public function scopeGiftPost($query, $id)
    {

        $query->where('type', 'Hediye')->where('child_id', $id);
    }

    public function setTextAttribute($text)
    {
        return $this->attributes['text'] = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', strip_tags($text, '<p><a><br><pre><i><b><u><ul><li><ol><blockquote><h1><h2><h3><h4><h5>'));
    }
}