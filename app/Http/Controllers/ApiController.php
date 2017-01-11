<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Child, DB, Log;
use App\Volunteer, App\Chat, App\Message, App\Subscriber;

class ApiController extends Controller
{
    public function children(){
        $data =  new \stdClass();
        $data->children = Child::select('id', 'first_name', 'last_name','gift_state', 'faculty_id', 'meeting_day', 'wish')->where('gift_state', 'Bekleniyor')
            ->with([
                'meetingPosts',
                'faculty',
                'meetingPosts.images'])
            ->whereHas('posts', function ($query) {
                $query->where('type', 'Tanışma')->approved();
            })
            ->orderby('meeting_day','desc')
            ->get();

        $data->waitGeneralChild = DB::table('children')->where('gift_state','Bekleniyor')->count();
        $data->roadGeneralChild = DB::table('children')->where('gift_state','Yolda')->count();
        $data->reachGeneralChild = DB::table('children')->where('gift_state','Bize Ulaştı')->count();
        $data->deliveredGeneralChild = DB::table('children')->where('gift_state','Teslim Edildi')->count();
        $data->totalChild = DB::table('children')->count();
        return json_encode($data);
    }

    public function child($id){
        $child = Child::select('id', 'first_name', 'last_name','gift_state', 'faculty_id', 'meeting_day', 'wish')
            ->with([
                'meetingPosts',
                'faculty',
                'meetingPosts.images'])
            ->whereId($id)
            ->first();
        return $child;
    }

    public function childForm(Request $request){
        $child = Child::where('id', $request->id)->with('faculty')->first();
        if( $child == null)
            abort(404,"Böyle bir çocuk bulunamadı.");

        $volunteer = Volunteer::where('email', $request->email)->first();
        if($volunteer == null){
            $volunteer = new Volunteer($request->only(['first_name','last_name', 'email','mobile','city']));
            $volunteer->save();
        }

        $chat = Chat::where('volunteer_id', $volunteer->id)->where('child_id', $child->id)->first();
        if($chat == null){
            $chat = new Chat([
                'volunteer_id' => $volunteer->id,
                'faculty_id' => $child->faculty->id,
                'child_id' => $child->id,
                'via' => $request->via,
                'status' => 'Açık'
            ]);
            $chat->save();
        }


        $message = new Message([ 'chat_id' => $chat->id, 'text' => $request->text ]);
        $message->save();

        return response("Talebiniz tarafımıza ulaştı.", 200);
    }

    public function token(Request $request){
        $subscriber = Subscriber::where('notification_token', $request->token)->first();

        if( $subscriber != null){
            return response("",200);
        }

        $subscriber = new Subscriber([
            'notification_token' => $request->token,
        ]);

        Log::info(
            "New iOS app user" .
            "\nIP: " . $request->ip() .
            "\nToken: " . $request->token
        );

        if($subscriber->save())
            return response("",200);
    }

}
