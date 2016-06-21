<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

//    protected $linkRequestView = 'admin.auth.passwords.email';
    protected $subject = 'Şifre Sıfırlama Linkiniz';
    protected $redirectPath = '/admin';
//    protected $resetView = 'admin.auth.passwords.reset';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return redirect()->back()->with('status', 'Şifrenizi sıfırlamak için ilgili talimatlar e-posta adresinize gönderilmiştir.');
    }

    protected function resetEmailBuilder()
    {
//        \Mail::send('email.admin.giftarrival', ['user' => $value, 'child' => $child], function ($message) use ($value, $child) {
//            $message
//                ->to($value->email)
//                ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
//                ->subject('Çocuğunuzun hediyesi bize ulaştı.');
//        });

        return function ($message) {
            $message
                ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
                ->subject($this->getEmailSubject());
        };
    }

}
