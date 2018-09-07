<?php

namespace App\Traits;

trait HasSlug
{
    public function updateSlug()
    {
        if (!$this->slugKeys) {
            return false;
        }
        $rawString = $this->getSlugValues()->implode('-');
        $this->slug = str_slug(remove_turkish($rawString));
        return $this->save();
    }

    public function scopeSlug($query, $slug)
    {
        $query->where('slug', $slug);
    }

    public function getSlugValues()
    {
        return collect($this->attributes)->only($this->slugKeys);
    }

    public static function findBySlug($slug)
    {
        return static::slug($slug)->first();
    }

    public static function findBySlugOrFail($slug)
    {
        return static::slug($slug)->firstOrFail();
    }
}
