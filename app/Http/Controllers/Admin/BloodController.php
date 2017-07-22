<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Blood;
use App\Models\Sms, App\Models\User;
use Auth;

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
    if ($request->has('search')) {
      $bloods = $bloods
        ->where(function ($query) use ($request) {
          $query->where('id', $request->search)
            ->orWhere('mobile', 'like', '%' . $request->search . '%')
            ->orWhere('city', 'like', '%' . $request->search . '%');
        });
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
      success_message('Kan bağışı SMS\'i ' . count($request->bloods) . ' kişiye başarıyla gönderildi.');
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

  public function editPeople()
  {
    $users = User::select('id', DB::raw('CONCAT(first_name, " ", last_name) AS fullname2'))->orderby('first_name')->pluck('fullname2', 'id');
    $responsibles = User::where('title', 'Kan Bağışı Görevlisi')->pluck('id')->toArray();
    return view('admin.blood.editPeople', compact('users','responsibles'));
  }

  public function updatePeople(Request $request)
  {

    if(User::where('title', 'Kan Bağışı Görevlisi')->update(['title' => 'Normal Üye'])
    && User::whereIn('id', $request->users)->update(['title' => 'Kan Bağışı Görevlisi'])){
      success_message('Kan Bağışı sorumluları başarıyla güncellendi.');

    }
    else{
      error_message('Kan Bağışı sorumluları güncellenemedi.');
      return redirect()->back()->withInput();
    }

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
