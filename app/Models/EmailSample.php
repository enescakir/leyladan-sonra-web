<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use App\Traits\Filterable;
use App\Traits\Downloadable;

class EmailSample extends Model
{
    use BaseActions;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'email_samples';
    protected $fillable = [
        'name', 'category', 'text'
    ];

    // Accessors
    public function getFormattedTextAttribute()
    {
        $pattern = '/(\[(\w|\s|-)+\])/ui';
        $replacement = '<strong>$1</strong>';
        $formatted = preg_replace($pattern, $replacement, $this->attributes['text']);
        return nl2br($formatted);
    }

    // Scopes
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('name', 'like', '%' . $search . '%')
                    ->orWhere('text', 'like', '%' . $search . '%');
        });
    }

    // Helpers
    public static function toCategorySelect($placeholder = null)
    {
        $result = static::orderBy('category')->pluck('category', 'category');
        return $placeholder
            ? collect(['' => $placeholder])->union($result)
            : $result;
    }
}
