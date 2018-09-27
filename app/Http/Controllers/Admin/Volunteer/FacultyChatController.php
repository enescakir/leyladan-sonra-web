<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Enums\ChatStatus;
use App\Filters\ChatFilter;
use App\Filters\ChildFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyChatController extends AdminController
{
    public function index(ChatFilter $chatFilters, ChildFilter $childFilters, Faculty $faculty)
    {
        if (request()->ajax()) {
            $children = $faculty->children()->select(['id', 'first_name', 'last_name', 'faculty_id'])
                                ->filter($childFilters)->has('chats')
                                ->withCount([
                                    'chats as open_count'     => function ($query) {
                                        return $query->where('status', ChatStatus::Open);
                                    },
                                    'chats as answered_count' => function ($query) {
                                        return $query->where('status', ChatStatus::Answered);
                                    },
                                    'chats as closed_count'   => function ($query) {
                                        return $query->where('status', ChatStatus::Closed);
                                    }
                                ])->orderBy('first_name')->get();

            return api_success(['children' => $children]);
        }

        return view('admin.faculty.chat.index');
    }
}