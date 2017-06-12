<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Blood;
use Datatables;
use App\Sms, App\User;
use Auth, DB;
use Session;

class BloodController extends Controller
{
    //TODO: Edit & Update functions

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.blood.index');
    }

    public function indexData()
    {
        return Datatables::of(Blood::all())->addColumn('operations', '
                <a class="edit btn btn-success btn-sm" href="{{ route("admin.blood.edit", $id) }}"><i class="fa fa-pencil"></i></a>
                <a class="delete btn btn-danger btn-sm" href="javascript:;"><i class="fa fa-trash"></i> </a>
           ')->make(true);
    }

    public function create()
    {
        return view('admin.blood.create');

    }

    public function store(Request $request)
    {
        if ($request->get('rh') == '1') {
            $request['rh'] = 1;
        }
        else {
            $request['rh'] = 0;
        }


        $this->validate($request, Blood::$validationRules, Blood::$validationMessages);
        $blood = new Blood($request->all());
        $blood->save();

        return redirect()->route('admin.blood.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Blood::destroy($id);

        return 'Success';
    }


    public function showSMS()
    {
        return view('admin.blood.sms');
    }

    public function previewSMS(Request $request)
    {
      $types = $request->type;
      $rh = $request->rh;
      $cities = $request->cities;
      $message = $request->message;

      $bloods = Blood::whereIn('city', $cities)->whereIn('blood_type', $types)->whereIn('rh', $rh)->get();

      return view('admin.blood.preview', compact(['bloods', 'message', 'types', 'rh', 'cities']));
    }

    public function sendSMS(Request $request)
    {
      $sms = new Sms([
        'title' => 'LEYLADANSNR',
        'message' => $request->message,
        'category' => 'Kan Bağışı',
        'receiver_count' => count($request->bloods),
        'sent_by' => Auth::user()->id,
      ]);

      if($sms->save()){
        $sms->send($request->bloods);
        Session::flash('success_message', 'Kan bağışı SMS\'i ' . count($request->bloods) . ' kişiye başarıyla gönderildi.' );
        return redirect()->route('admin.blood.sms.show');
      } else {
        return 'Bir hata ile karşılaşıldı.';
      }
    }

    public function testSMS(Request $request)
    {
      $sms = new Sms([
        'title' => 'LEYLADANSNR',
        'message' => $request->message,
        'category' => 'Kan Bağışı Test',
        'receiver_count' => 1,
        'sent_by' => Auth::user()->id,
      ]);

      if($sms->save()){
        $sms->send($request->tester);
        return $sms;
      } else {
        return 'Bir hata ile karşılaşıldı.';
      }
    }

    public function checkBalance()
    {
      return ["balance" => Sms::checkBalance()];
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPeople()
    {
        $users = User::select('id', DB::raw('CONCAT(first_name, " ", last_name) AS fullname2'))->orderby('first_name')->pluck('fullname2', 'id');
        $responsibles = User::where('title', 'Kan Bağışı Görevlisi')->pluck('id')->toArray();
        return view('admin.blood.editPeople', compact('users','responsibles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePeople(Request $request)
    {

        if(User::where('title', 'Kan Bağışı Görevlisi')->update(['title' => 'Normal Üye'])
            && User::whereIn('id', $request->users)->update(['title' => 'Kan Bağışı Görevlisi'])){
              Session::flash('success_message', 'Kan Bağışı sorumluları başarıyla güncellendi.');

        }
        else{
            Session::flash('error_message', ' Kan Bağışı sorumluları güncellenemedi.');
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.blood.people.edit');
    }
}
