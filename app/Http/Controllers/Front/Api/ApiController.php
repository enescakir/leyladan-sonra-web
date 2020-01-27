<?php

namespace App\Http\Controllers\Front\Api;

use App\Enums\GiftStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Child;
use DB;
use App\Models\Volunteer;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Subscriber;

class ApiController extends Controller
{
    public function children()
    {
        $children = Child::select('id', 'first_name', 'last_name', 'gift_state', 'faculty_id', 'meeting_day', 'wish', 'featured_media_id', 'until', 'meeting_post_id')
            ->where('gift_state', GiftStatus::Waiting)
            ->with(['featuredMedia', 'faculty'])
            ->whereHas('meetingPost', function ($query) {
                $query->approved();
            })
            ->whereDate('until', '>', now())
            ->latest('meeting_day')
            ->get();

        $waitGeneralChild = DB::table('children')->where('gift_state', GiftStatus::Waiting)->count();
        $roadGeneralChild = DB::table('children')->where('gift_state', GiftStatus::OnRoad)->count();
        $reachGeneralChild = DB::table('children')->where('gift_state', GiftStatus::Arrived)->count();
        $deliveredGeneralChild = DB::table('children')->where('gift_state', GiftStatus::Delivered)->count();
        $totalChild = DB::table('children')->count();

        return compact('children', 'waitGeneralChild', 'roadGeneralChild', 'reachGeneralChild', 'deliveredGeneralChild', 'totalChild');
    }

    public function child($id)
    {
        $child = Child::select('id', 'first_name', 'last_name', 'gift_state', 'faculty_id', 'meeting_day', 'wish')
            ->with(['featuredMedia', 'faculty'])
            ->whereHas('meetingPost', function ($query) {
                $query->approved();
            })
            ->whereDate('until', '>', now())
            ->findOrFail($id);
        return $child;
    }

    public function childForm(Request $request)
    {
        $child = Child::with('faculty')->findOrFail($request->id);

        $volunteer = Volunteer::where('email', $request->email)->first();
        if ($volunteer == null) {
            $volunteer = Volunteer::create($request->only(['first_name', 'last_name', 'email', 'mobile', 'city']));
        }

        $chat = Chat::where('volunteer_id', $volunteer->id)->where('child_id', $child->id)->first();
        if ($chat == null) {
            $chat = Chat::create([
                'volunteer_id' => $volunteer->id,
                'faculty_id'   => $child->faculty->id,
                'child_id'     => $child->id,
                'via'          => $request->via,
                'status'       => 'Açık'
            ]);
        }

        $message = Message::create(['chat_id' => $chat->id, 'text' => $request->text]);

        return "Talebiniz tarafımıza ulaştı.";
    }

    public function token(Request $request)
    {
        $subscriber = Subscriber::where('notification_token', $request->token)->first();

        if ($subscriber != null) {
            return response('', 200);
        }

        $subscriber = new Subscriber([
            'notification_token' => $request->token,
        ]);

        if ($subscriber->save()) {
            return response('', 200);
        }
    }
}
