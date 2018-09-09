<?php

namespace App\Http\Controllers\Admin\Blood;

use App\Filters\SmsFilter;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Blood;
use App\Models\Sms;
use Auth;

class SmsController extends AdminController
{

    public function index(SmsFilter $filters)
    {
        $messages = Sms::where('category', 'Kan Bağışı')->orderBy('id', 'DESC')->with('sender');
        $messages->filter($filters);
        $messages = $messages->paginate(request('per_page', 25));

        $senders = Sms::toSenderSelect('Hepsi', 'Kan Bağışı');

        return view('admin.blood.sms', compact('messages', 'senders'));
    }

    public function show()
    {
        return view('admin.blood.send');
    }

    public function preview(Request $request)
    {
        $this->validate($request, [
            'cities'      => 'required',
            'blood_types' => 'required',
            'rhs'         => 'required',
            'message'     => 'required|string|max:255',
        ]);

        $blood_types = $request->blood_types;
        $rhs = $request->rhs;
        $cities = $request->cities;
        $message = $request->message;

        $bloods = Blood::whereIn('city', $cities)->whereIn('blood_type', $blood_types)->whereIn('rh', $rhs)->get();

        return view('admin.blood.preview', compact('bloods', 'message', 'blood_types', 'rhs', 'cities'));
    }

    public function send(Request $request)
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
            session_success(__('messages.blood.sms.successful', ['count' => count($request->bloods)]));
            return redirect()->route('admin.blood.sms.show');
        } else {
            session_error(__('messages.blood.sms.error'));
            return redirect()->back()->withInput();
        }
    }

    public function test(Request $request)
    {
        $sms = new Sms([
            'title'          => 'LEYLADANSNR',
            'message'        => $request->message,
            'category'       => 'Kan Bağışı Test',
            'receiver_count' => 1,
            'sent_by'        => Auth::user()->id,
        ]);

        if ($sms->save()) {
            $sms->send(make_mobile($request->number));
            return api_success($sms);
        } else {
            return api_error('Bir hata ile karşılaşıldı.');
        }
    }

    public function checkBalance()
    {
        return api_success(['balance' => Sms::checkBalance()]);
    }
}
