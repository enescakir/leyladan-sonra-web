<?php
// TODO: New voting engine
namespace App\Http\Controllers\Admin\Miscellaneous;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Auth;
use DB;

class VoteController extends AdminController
{

    public function vote()
    {
        return view('admin.oylama');
    }

    public function voteStore(Request $request)
    {
        $user = Auth::user();
        $votes = DB::select('select * from votes where used_by = ?', [$user->id]);
        if (count($votes) > 0) {
            session_error('Daha önceden oy kullanmışsınız');
            return redirect()->back()->withInput();
        }
        if (!($request->has('first') && $request->has('second'))) {
            session_error('Lütfen bütün tarihleri oylayınız');
            return redirect()->back()->withInput();
        }

        session_succes('Başarıyla oy kullandınız');
        DB::insert('insert into votes (used_by, faculty_name, first, second) values (?, ?, ?, ?)', [$user->id, $user->faculty->slug, $request->first, $request->second]);

        return view('admin.vote');
    }
}
