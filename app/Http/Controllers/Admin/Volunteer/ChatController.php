<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Filters\ChildFilter;
use App\Http\Controllers\Controller;
use App\Models\Child;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ChildFilter $filters)
    {
        if (request()->ajax()) {
            $children = Child::select(['id', 'first_name', 'last_name', 'faculty_id'])
                ->filter($filters)->has('chats')
                ->withChatCounts()
                ->orderBy('first_name')->get();

            return api_success(['children' => $children]);
        }

        return view('admin.chat.index');
    }

}
