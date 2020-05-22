<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Services\ProcessService;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Chat $chat)
    {
        $this->authorize('view', $chat);

        $chat->load([
            'volunteer' => function ($query) {
                return $query->withCount(['children', 'chats']);
            }
        ]);
        $messages = $chat->messages()
            ->with('sender:id,first_name,last_name', 'answerer:id,first_name,last_name')
            ->oldest()->get();

        return api_success(['chat' => $chat, 'messages' => $messages]);

    }

    public function update(Request $request, Chat $chat)
    {
        $this->authorize('update', $chat);

        if ($request->action == 'close') {
            $chat->close();
            $chat->answerMessages();
        } elseif ($request->action == 'answer') {
            $chat->answer();
            $chat->answerMessages();
        } elseif ($request->action == 'volunteer') {
            $volunteer = Volunteer::findOrFail($request->volunteer_id);
            $chat->child->volunteered($volunteer);
            $chat->answer();
            $chat->answerMessages();
            ProcessService::create($chat->child, ProcessType::VolunteerDecided, $volunteer);
        }

        return api_success();
    }
}
