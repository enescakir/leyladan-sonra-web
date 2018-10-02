<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Filters\ChildFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyChatController extends AdminController
{
    public function index(ChildFilter $childFilters, Faculty $faculty)
    {
        if (request()->ajax()) {
            $children = $faculty->children()->select(['id', 'first_name', 'last_name', 'faculty_id'])
                                ->filter($childFilters)->has('chats')
                                ->withChatCounts()
                                ->when(request()->status == 'active', function ($query){
                                    return $query->has('activeChats');
                                })
                                ->orderBy('first_name')->get();

            return api_success(['children' => $children]);
        }

        return view('admin.faculty.chat.index');
    }

}