<?php

namespace App\Models;

use App\Enums\PostType;
use App\Services\ProcessService;
use EnesCakir\Helper\Traits\Approvable;
use EnesCakir\Helper\Traits\BaseActions;
use EnesCakir\Helper\Traits\Filterable;
use EnesCakir\Helper\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Post extends Model implements HasMedia
{
    use BaseActions;
    use Approvable {
        approve as protected approveTrait;
    }
    use HasMediaTrait;
    use Filterable;

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

    public function scopeMeetingPost($query)
    {
        $query->where('type', PostType::Meeting);
    }

    public function scopeGiftPost($query)
    {
        $query->where('type', PostType::Delivery);
    }

    // Helpers
    public function approve($approval = true)
    {
        $this->approveTrait($approval);

        (new ProcessService())->createPost($this->child, $approval, $this);

        return $this->save();
    }

    public function change($request, $suffix)
    {
        $this->text = $request->{$suffix . '_text'};

        if ($this->isDirty('text')) {
            $this->approve(false);
        }
        $this->save();

        if ($request->filled("mediaId.{$suffix}")) {
            $this->addTempMedia($request->mediaId[$suffix], $request->mediaName[$suffix], $request->mediaRatio[$suffix],
                $request->mediaFeature[$suffix]);
        }

    }

    public function addTempMedia($ids, $names, $ratios, $features)
    {
        foreach ($ids as $index => $id) {
            $media = $this->addMedia(
                storage_path('app/public/tmp/' . $names[$index]),
                ['ratio' => $ratios[$index]]
            );
            if ($features[$index] == '1') {
                $this->child->featuredMedia()->associate($media);
                $this->child->save();
            }
        }
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->fit(Manipulations::FIT_CONTAIN, 200, 200);
        $this->addMediaConversion('medium')->fit(Manipulations::FIT_CONTAIN, 500, 1000);
        $this->addMediaConversion('large')->fit(Manipulations::FIT_CONTAIN, 1000, 1000);
    }
}
