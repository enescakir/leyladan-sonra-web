<?php

namespace App\Models;

use App\Enums\PostType;
use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use App\Traits\HasMediaTrait;
use App\Traits\BaseActions;
use App\Traits\Approvable;

class Post extends Model implements HasMedia
{
    use BaseActions;
    use Approvable {
        approve as protected approveTrait;
    }
    use HasMediaTrait;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'posts';
    protected $fillable = ['child_id', 'approved_by', 'approved_at', 'text', 'type'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'approved_at'];

    // Relations
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    // Accessors
    public function getApprovalLabelAttribute()
    {
        if ($this->isApproved()) {
            return "<span class='label label-success'> Onaylandı </span>";
        }
        return "<span class='label label-danger'> Onaylanmadı </span>";
    }

    // Mutators
    public function setTextAttribute($text)
    {
        $text = trim(strip_tags($text))
            ? clean_text($text)
            : null;

        return $this->attributes['text'] = $text;
    }

    // Scopes
    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('id', $search)
                   ->orWhere('text', 'like', '%' . $search . '%')
                   ->orWhereHas('child', function ($query3) use ($search) {
                       $query3->search($search);
                   });
        });
    }

    public function scopeFaculty($query, $id)
    {
        $query->whereHas('child', function ($query2) use ($id) {
            $query2->where('faculty_id', $id);
        });
    }

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }

    public function scopeMeetingPost($query, $id)
    {
        $query->where('type', PostType::Meeting)->where('child_id', $id);
    }

    public function scopeGiftPost($query, $id)
    {
        $query->where('type', PostType::Delivery)->where('child_id', $id);
    }

    // Helpers
    public function approve($approval = true)
    {
        $this->approveTrait($approval);

        $processDesc = $approval
            ? 'Çocuğun yazısı onaylandı.'
            : 'Çocuğun yazısının onayı kaldırıldı.';

        $this->child->processes()->create([
            'desc' => $processDesc
        ]);

        return $this->save();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CONTAIN, 200, 200);
        $this->addMediaConversion('medium')->fit(Manipulations::FIT_CONTAIN, 500, 1000);
        $this->addMediaConversion('large')->fit(Manipulations::FIT_CONTAIN, 1000, 1000);
    }
}
