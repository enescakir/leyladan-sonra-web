<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Blood, App\Models\Sms, App\Models\User;
use App\Enums\UserTitle;
use Auth, Excel;

class BloodController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $bloods = Blood::orderBy('id', 'DESC');
    if ($request->has('blood_type')) {
      $bloods = $bloods->where('blood_type', $request->blood_type);
    }
    if ($request->has('rh')) {
      $bloods = $bloods->where('rh', $request->rh);
    }
    if ($request->has('city')) {
      $bloods = $bloods->where('city', $request->city);
    }
    if ($request->has('search')) {
      $bloods = $bloods
        ->where(function ($query) use ($request) {
          $query->where('id', $request->search)
            ->orWhere('mobile', 'like', '%' . $request->search . '%')
            ->orWhere('city', 'like', '%' . $request->search . '%');
        });
    }
    if ($request->has('csv')) {
      $bloods = $bloods->get(['id', 'blood_type', 'rh', 'mobile', 'city', 'created_at']);
      Excel::create('LS_KanBagisici_' . date("d_m_Y"), function($excel) use ($bloods) {
        $excel->sheet('Bagiscilar', function($sheet) use ($bloods) {
          $sheet->fromArray($bloods);
        });
      })->download('xlsx');
    }
    $bloods = $bloods->paginate($request->per_page ?: 25);
    return view('admin.blood.index', compact('bloods'));
  }

  public function create()
  {
    return view('admin.blood.create');

  }

  public function store(Request $request)
  {
    $request['mobile'] = make_mobile($request->mobile);
    $this->validateBlood($request);
    $blood = Blood::create($request->all());
    session_success(__('messages.blood.create', ['mobile' =>  $blood->mobile]));
    return redirect()->route('admin.blood.index');
  }

  public function edit(Blood $blood)
  {
    return view('admin.blood.edit', compact(['blood']));
  }

  public function update(Request $request, Blood $blood)
  {
    $request['mobile'] = make_mobile($request->mobile);
    $this->validateBlood($request, true);
    $blood->update($request->all());
    session_success(__('messages.blood.update', ['mobile' =>  $blood->mobile]));
    return redirect()->route('admin.blood.index');
  }

  public function destroy(Blood $blood)
  {
    $blood->delete();
    return $blood;
  }


  public function showSMS()
  {
    return view('admin.blood.sms');
  }

  public function previewSMS(Request $request)
  {
    $this->validate($request, [
      'cities'       => 'required',
      'blood_types' => 'required',
      'rhs'         => 'required',
      'message'    => 'required|string|max:255',
    ]);

    $blood_types = $request->blood_types;
    $rhs         = $request->rhs;
    $cities      = $request->cities;
    $message     = $request->message;

    $bloods = Blood::whereIn('city', $cities)->whereIn('blood_type', $blood_types)->whereIn('rh', $rhs)->get();

    return view('admin.blood.preview', compact(['bloods', 'message', 'blood_types', 'rhs', 'cities']));
  }

  public function sendSMS(Request $request)
  {
    $sms = new Sms([
      'title'          => 'LEYLADANSNR',
      'message'        => $request->message,
      'category'       => 'Kan Bağışı',
      'receiver_count' => count($request->bloods),
      'sent_by'        => Auth::user()->id,
    ]);

    if ($sms->save()) {
      $sms->send($request->bloods);
      session_success(__('messages.blood.sms.successful', ['count' =>  count($request->bloods)]));
      return redirect()->route('admin.blood.sms.show');
    } else {
      error_message(__('messages.blood.sms.error'));
      return redirect()->back()->withInput();
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

    if ($sms->save()) {
      $sms->send( make_mobile($request->number) );
      return $sms;
    } else {
      return 'Bir hata ile karşılaşıldı.';
    }
  }

  public function checkBalance()
  {
    return ["balance" => Sms::checkBalance()];
  }

  public function editPeople()
  {
    $users = User::orderby('first_name')->get()->pluck('fullname', 'id');
    $responsibles = User::title( UserTitle::BloodMember )->get()->pluck('id');
    return view('admin.blood.people', compact('users','responsibles'));
  }

  public function updatePeople(Request $request)
  {
    User::title( UserTitle::BloodMember )->update(['title' => UserTitle::NormalMember]);
    User::whereIn('id', $request->users)->update(['title' => UserTitle::BloodMember]);
    session_success(__('messages.blood.people'));
    return redirect()->route('admin.blood.people.edit');
  }

  private function validateBlood(Request $request, $isUpdate = false)
  {
    $this->validate($request, [
      'mobile'     => 'required|max:255' . ($isUpdate ? '' : '|unique:bloods'),
      'city'       => 'required|string|max:255',
      'blood_type' => 'required|string|max:255',
      'rh'         => 'required|string|max:255',
    ]);
  }
}
