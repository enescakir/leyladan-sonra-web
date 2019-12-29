<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Filters\ChildFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ChildFilter $filters, Faculty $faculty)
    {
        if (request()->ajax()) {
            $children = $faculty->children()
                ->select(['id', 'first_name', 'last_name', 'faculty_id'])
                ->filter($filters)->has('chats')
                ->withChatCounts()
                ->when(request()->status == 'active', function ($query) {
                    return $query->has('activeChats');
                })
                ->orderBy('first_name')->get();

            return api_success(['children' => $children]);
        }

        return view('admin.faculty.chat.index');
    }

}