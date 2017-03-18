<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Blood;
use Datatables;
use App\Sms;
use Auth;
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
           ')->editColumn('first_name', '{{$first_name . " " . $last_name}}')->editColumn('birthday', '{{date("d.m.Y", strtotime($birthday))}}')->make(true);
    }

    public function create()
    {
        return view('admin.blood.create');

    }

    public function store(Request $request)
    {
        if ($request->get('gender') == '1') {
            $request['gender'] = "Bay";
        }
        else {
            $request['gender'] = "Bayan";
        }

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
}
