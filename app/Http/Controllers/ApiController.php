<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Child, DB;

class ApiController extends Controller
{
    public function children(){
        $data =  new \stdClass();
        $data->children = Child::select('id', 'first_name', 'last_name','gift_state', 'faculty_id')->where('gift_state', 'Bekleniyor')
            ->with([
                'posts' => function ($query) { $query->where('type','Tanışma');},
                'faculty',
                'posts.images'])
            ->orderby('meeting_day','desc')
            ->limit(100)->get();
        $data->waitGeneralChild = DB::table('children')->where('gift_state','Bekleniyor')->count();
        $data->roadGeneralChild = DB::table('children')->where('gift_state','Yolda')->count();
        $data->reachGeneralChild = DB::table('children')->where('gift_state','Bize Ulaştı')->count();
        $data->deliveredGeneralChild = DB::table('children')->where('gift_state','Teslim Edildi')->count();
        $data->totalChild = DB::table('children')->count();
        return json_encode($data);
    }

    public function child($id){
        $child = Child::select('id', 'first_name', 'last_name','gift_state', 'faculty_id')->whereId($id)
            ->with([
                'posts',
                'faculty',
                'posts.images'])
            ->first();
        return $child;
    }

}
