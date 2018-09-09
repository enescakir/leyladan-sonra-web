<?php

namespace App\Models;

use App\Traits\Downloadable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use App\Traits\HasBirthday;
use App\Enums\PostType;
use App\Enums\ChatStatus;
use App\Enums\GiftStatus;
use Excel;
use DB;

class Child extends Model
{
    use BaseActions;
    use HasBirthday;
    use Filterable;
    use Downloadable;

    // Properties
    protected $table = 'children';
    protected $fillable = [
      'faculty_id', 'department', 'first_name', 'last_name', 'diagnosis',
      'diagnosis_desc', 'taken_treatment', 'child_state', 'child_state_desc',
      'gender', 'meeting_day', 'birthday', 'wish', 'g_first_name', 'g_last_name',
      'g_mobile', 'g_email', 'province', 'city', 'address', 'extra_info',
      'volunteer_id', 'verification_doc', 'gift_state', 'on_hospital', 'until', 'slug'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'meeting_day', 'birthday', 'until'];
    protected $appends = ['full_name'];
    protected $slugKeys = ['first_name', 'id'];

    // Relations
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function meetingPosts()
    {
        return $this->hasMany(Post::class)->where('type', PostType::Meeting);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function openChats()
    {
        return $this->hasMany(Chat::class)->whereIn('status', [ChatStatus::Open, ChatStatus::Answered]);
    }

    public function unansweredMessages()
    {
        return $this->hasManyThrough(Message::class, Chat::class)->whereNull('answered_at');
    }

    public function processes()
    {
        return $this->hasMany(Process::class)->with(['creator']);
    }

    // Scopes
    public function scopeGift($query, $gift_state)
    {
        $query->where('gift_state', $gift_state);
    }

    public function scopeDepartment($query, $department)
    {
        $query->where('department', $department);
    }

    public function scopeDiagnosis($query, $diagnosis)
    {
        $query->where('diagnosis', $diagnosis);
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query2) use ($search) {
            $query2->where('id', $search)
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', '%' . $search . '%');
        });
    }

    // Global Methods
    public static function download($children)
    {
        $children = $children->get();
        Excel::create('LS_Cocuklar_' . date('d_m_Y'), function ($excel) use ($children) {
            $excel->sheet('Cocuklar', function ($sheet) use ($children) {
                $sheet->fromArray($children, null, 'A1', true);
            });
        })->download('xlsx');
    }

    // Accessors
    public function getUserNameListAttribute()
    {
        return implode(', ', $this->users->pluck('full_name')->toArray());
    }

    public function getUserListAttribute()
    {
        return $this->users->pluck('id');
    }

    public function getGiftStateLabelAttribute()
    {
        $status = $this->attributes['gift_state'];
        switch ($status) {
            case GiftStatus::Waiting:
                return "<span class='label label-danger'>{$status}</span>";
            case GiftStatus::OnRoad:
                return "<span class='label label-warning'>{$status}</span>";
            case GiftStatus::Arrived:
                return "<span class='label label-primary'>{$status}</span>";
            case GiftStatus::Delivered:
                return "<span class='label label-success'>{$status}</span>";
            default:
                return "<span class='label label-default'>{$status}</span>";
        }
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function getMeetingDayHumanAttribute()
    {
        return date('d.m.Y', strtotime($this->attributes['meeting_day']));
    }

    public function getBirthdayHumanAttribute()
    {
        return date('d.m.Y', strtotime($this->attributes['birthday']));
    }

    public function getUntilHumanAttribute()
    {
        return date('d.m.Y', strtotime($this->attributes['until']));
    }

    // Mutators
    public function setGMobileAttribute($g_mobile)
    {
        return $this->attributes['g_mobile'] = make_mobile($g_mobile);
    }
}
