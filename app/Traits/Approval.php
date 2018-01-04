<?php

namespace App\Traits;

use Carbon\Carbon;
use Auth;
use App\Models\User;

trait Approval
{
    public function approve($approval = true)
    {
        if ($approval) {
            $this->approved_at = Carbon::now();
            $this->approved_by = Auth::user()->id;
        } else {
            $this->approved_at = null;
            $this->approved_by = null;
        }
        return $this->save();
    }

    public function isApproved()
    {
        return !is_null($this->approved_at);
    }

    public function scopeApproved($query, $approval = true)
    {
        if ($approval) {
            $query->whereNotNull('approved_at');
        } else {
            $query->whereNull('approved_at');
        }
    }

    public function getApprovedAtLabelAttribute()
    {
        return date("d.m.Y H:i", strtotime($this->attributes['approved_at']));
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
