<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatMessageController extends AdminController
{

    public function index(Request $request, Chat $chat)
    {
        $chat->load([
            'volunteer' => function ($query) {
                return $query->withCount(['children', 'chats']);
            }
        ]);
        $messages = $chat->messages()->with('sender:id,first_name,last_name', 'answerer:id,first_name,last_name')
                         ->oldest()->get();

        return api_success(['chat' => $chat, 'messages' => $messages]);

    }


    public function close($id)
    {
        $chat = Chat::find($id);
        $chat->status = 'Kapalı';
        $chat->save();
        return ['child_id' => $chat->child_id, 'volunteer_id' => $chat->volunteer_id, 'chat_id' => $chat->id];
    }
}
