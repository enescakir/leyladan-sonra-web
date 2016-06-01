<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VolunteerMessageRequest;
use App\Child, App\Post, App\Faculty, App\News, App\Channel;
use App\Volunteer, App\Chat, App\Message, App\Testimonial, DB;

class FrontController extends Controller
{
    //

    //TODO: Don't show not approved
    public function home(){
        $children = Child::where('gift_state', 'Bekleniyor')
            ->with([
                'posts' => function ($query) { $query->where('type','Tanışma');},
                'faculty',
                'posts.images'])
            ->orderby('meeting_day','desc')
            ->simplePaginate(20);
        return view('front.home', compact(['children']));
    }


    public function news(){
        $channels = Channel::with('news')->get();
        return view('front.news', compact(['channels']));
    }

    public function us(){
        return view('front.us');
    }

    public function privacy(){
        return view('front.privacy');
    }

    public function tos(){
        return view('front.tos');
    }

    public function contact(){
        return view('front.contact');
    }

    public function testimonials(){
        $testimonials = Testimonial::orderBy(DB::raw('LENGTH(text)'), 'DESC')->get();
        return view('front.testimonials', compact(['testimonials']));
    }

    public function newskit(){
        return view('front.newskit');
    }

    public function leyla(){
        return view('front.leyla');
    }

    public function sss(){
        return view('front.sss');
    }

    public function blogs(){
        return view('front.blogs');
    }

    public function blog($name){
        return view('front.blog');
    }

    public function faculties(){
        $faculties = Faculty::all();
        return view('front.faculties', compact(['faculties']));
    }

    public function faculty($facultyName){
        $faculty = Faculty::where('slug', $facultyName)->first();
        return view('front.faculty', compact(['faculty']));
    }

    public function child($facultyName, $childSlug){
        $child = Child::where('slug', $childSlug)->with('faculty', 'posts', 'posts.images')->first();
        if( $child->faculty->slug != $facultyName){
            abort(404);
        }
        return view('front.child', compact(['child']));
    }

    public function childMessage(VolunteerMessageRequest $request, $facultyName, $childSlug){
        $child = Child::where('slug', $childSlug)->with('faculty')->first();

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
                'via' => 'Web',
                'status' => 'Açık'
            ]);
            $chat->save();
        }


        $message = new Message([ 'chat_id' => $chat->id, 'text' => $request->text ]);
        $message->save();

        return "Tebrikler mesaj alındı";
    }


}
