<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Base;
use App\Enums\ChatStatus;

use Carbon\Carbon;

class Chat extends Model
{
    use Base;
    // Properties
    protected $table    = 'chats';
    protected $fillable = ['volunteer_id', 'faculty_id', 'child_id', 'via', 'status'];

    // Relations
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        $query->where('status', ChatStatus::Open);
    }

    // Methods
    public function avgTime()
    {
        $messages = $this->messages;
        $sum = 0;
        $counter = 0;

        foreach ($messages as $message) {
            if ($message->sent_at == null) {
                $counter += 1;
                if ($message->answered_at == null) {
                    $sum += $message->created_at->diffInMinutes(Carbon::now());
                } else {
                    $sum += $message->created_at->diffInMinutes($message->answered_at);
                }
            }
        }
        if ($counter == 0) {
            return 0;
        }
        return $sum / $counter / 60;
    }
}
