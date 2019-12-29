<?php

namespace App\Http\Controllers\Admin\Miscellaneous;

use App\CacheManagers\ChatCacheManager;
use App\CacheManagers\PostCacheManager;
use App\CacheManagers\UserCacheManager;
use App\Enums\ChatStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SidebarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data(Request $request)
    {
        $data = [
            'unapproved-user-count' => UserCacheManager::count([
                'faculty_id' => auth()->user()->faculty_id, 'approval' => 0
            ]),
            'unapproved-post-count' => PostCacheManager::count([
                'faculty_id' => auth()->user()->faculty_id, 'approval' => 0
            ]),
            'open-chat-count'       => ChatCacheManager::count([
                'faculty_id' => auth()->user()->faculty_id, 'status' => ChatStatus::Open
            ]),
        ];
        return api_success($data);
    }
}