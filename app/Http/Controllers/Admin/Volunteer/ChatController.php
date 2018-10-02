<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Filters\ChildFilter;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Child;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends AdminController
{
    public function index(ChildFilter $childFilters)
    {
        if (request()->ajax()) {
            $children = Child::select(['id', 'first_name', 'last_name', 'faculty_id'])
                                ->filter($childFilters)->has('chats')
                                ->withChatCounts()
                                ->orderBy('first_name')->get();

            return api_success(['children' => $children]);
        }

        return view('admin.chat.index');
    }

}
