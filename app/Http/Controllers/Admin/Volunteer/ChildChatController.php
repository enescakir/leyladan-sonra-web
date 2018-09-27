<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Filters\ChatFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Process;
use App\Models\Chat;
use App\Models\Volunteer;
use Auth;

class ChildChatController extends AdminController
{

    public function index(ChatFilter $filters, Child $child)
    {
        $child->load(['faculty', 'users:users.id,first_name,last_name']);
        $child->append('gift_state_label');

        $chats = $child->chats()->filter($filters)->with(['volunteer' => function($query){
            return $query->withCount(['children', 'chats']);
        }])->latest()->get();

        return api_success(['chats' => $chats, 'child' => $child]);
    }

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
}