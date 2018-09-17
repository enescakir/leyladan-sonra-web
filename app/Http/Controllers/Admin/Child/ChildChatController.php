<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Process;
use App\Models\Feed;
use App\Models\Chat;
use App\Models\Volunteer;
use Auth;

class ChildChatController extends AdminController
{

    public function volunteered(Request $request, $id)
    {
        $child = Child::find($id);
        if ($child == null) {
            abort(404);
        }

        $volunteer = Volunteer::find($request->volunteer_id);

        $child->volunteer_id = $request->volunteer_id;
        $child->gift_state = 'Yolda';
        if ($child->save()) {
            $process = new Process;
            $process->created_by = Auth::user()->id;
            $process->child_id = $child->id;
            $process->desc = $volunteer->first_name . ' ' . $volunteer->last_name . ' gönüllü olarak belirlendi.';
            $process->save();
        }

        return json_encode(['message' => $child->first_name . ' gönüllüsü ' . $volunteer->first_name . ' olarak güncellendi.']);
    }

    public function chats(Request $request, $id)
    {
        $child = Child::find($id);
        $chats = $child->chats()->with('volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift')->orderBy('id', 'desc')->get();
        return $chats;
    }

    public function chat($id, $chatID)
    {
        $chat = Chat::where('id', $chatID)->with('messages', 'volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift', 'messages.sender', 'messages.answerer')->first();
        return $chat;
    }

    public function chatsOpens(Request $request, $id)
    {
        $child = Child::find($id);
        $chats = $child->openChats()->with('volunteer', 'volunteer.boughtGift', 'volunteer.volunteeredGift')->orderBy('id', 'desc')->get();
        return $chats;
    }
}