<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;
use App\Traits\Approval;

use App\Enums\ImageRatio;

use Carbon\Carbon;
use Auth;

class Post extends Model
{
    use Base;
    use Approval;
    // Properties
    protected $table    = 'posts';
    protected $fillable = ['child_id', 'approved_by', 'approved_at', 'text', 'type'];
    protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'approved_at'];

    // Relations
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    // Mutators
    public function setTextAttribute($text)
    {
        return $this->attributes['text'] = clean_text($text);
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
    public function approve($approval)
    {
        if ($approval) {
            $this->approved_at = Carbon::now();
            $this->approved_by = Auth::user()->id;
            $this->child->processes()->create([
                'desc' => 'Çocuğun yazısı onaylandı.'
            ]);
        } else {
            $this->approved_at = null;
            $this->approved_by = null;
            $this->child->processes()->create([
                'desc' => 'Çocuğun yazısının onayı kaldırıldı.'
            ]);
        }
        return $this->save();
    }

    public function getApprovalLabelAttribute()
    {
        if ($this->isApproved()) {
            return "<span class='label label-success'> Onaylandı </span>";
        }
        return "<span class='label label-danger'> Onaylanmadı </span>";
    }

    public function addImage($file, $data)
    {
        $postImage = PostImage::create([
          'post_id' => $this->id,
          'name'    => $child->id . str_random(5) . '.jpg',
          'ratio'   => $data['ratio'],
        ]);

        $imageWidth = $data['ratio'] == ImageRatio::Landscape ? 1000 : 800;
        // Increase limits for image process
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        Image::make($file)
        ->rotate(-$data['rotation'])
        ->crop($data['w'], $data['h'], $data['x'], $data['y'])
        ->resize($imageWidth, null, function ($constraint) {
            $constraint->aspectRatio();
        })
        ->save(upload_path('child') . '/' . $postImage->name, 90);
        ini_restore("memory_limit");
        ini_restore("max_execution_time");
    }
}
