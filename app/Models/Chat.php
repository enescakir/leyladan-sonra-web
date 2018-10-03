<?php

namespace App\Models;

use App\Traits\Filterable;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseActions;
use App\Enums\ChatStatus;

class Chat extends Model
{
    use BaseActions;
    use Filterable;

    // Properties
    protected $table = 'chats';
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
    public function scopeSearch($query, $search)
    {
        if (is_null($search)) {
            return;
        }

        $query->whereHas('volunteer', function ($query2) use ($search) {
            $query2->search($search);
        });
    }

    public function scopeOpen($query)
    {
        $query->where('status', ChatStatus::Open);
    }

    public function scopeActive($query)
    {
        $query->whereIn('status', ChatStatus::actives());
    }

    // Accessors
    public function averageTime()
    {
        return $this->messages->filter(function ($message){
            return $message->is_sent == false;
        })->avg('answerTime');
    }

    // Methods
    public function close()
    {
        $this->status = ChatStatus::Closed;
        $this->save();

    }

    public function answer()
    {
        $this->status = ChatStatus::Answered;
        $this->save();
    }

    public function answerMessages()
    {
        $this->messages()->sent(false)->answered(false)->get()->each->answer();
    }
}
