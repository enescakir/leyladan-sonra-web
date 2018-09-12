<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Enums\GiftStatus;
use App\Enums\PostType;
use App\Enums\UserRole;
use App\Http\Requests\CreateChildRequest;
use App\Models\Child;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Diagnosis;
use App\User;
use App\Post;
use App\PostImage;
use App\Process;
use App\Feed;
use App\Chat;
use App\Volunteer;
use Auth;
use Carbon\Carbon;
use File;
use App\Filters\ChildFilter;

class FacultyMessageController extends AdminController
{
    public function messages($id)
    {
        $authUser = Auth::user();
        $colors = ['purple', 'red', 'green'];
        $faculty = Faculty::find($id);
        $children = $faculty->children()->has('chats')->withCount('chats')->orderBy('id', 'desc')->get();
        return view('admin.faculty.messages', compact(['children', 'faculty', 'colors', 'authUser']));
    }

    public function messagesUnanswered($id)
    {
        $authUser = Auth::user();
        $colors = ['purple', 'red', 'green'];
        $faculty = Faculty::find($id);
        $children = $faculty->children()->has('openChats')->withCount('openChats', 'unansweredMessages')->orderBy('id', 'desc')->get();
        return view('admin.faculty.messages_unanswered', compact(['children', 'faculty', 'colors', 'authUser']));
    }

}
