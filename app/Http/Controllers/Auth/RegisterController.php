<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Notifications\NewUser as NewUserNotification;

use Auth, Log, Session, Mail;
use App\Faculty;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
      $faculties = Faculty::orderby('full_name')->get();
      return view('auth.register', compact(['faculties']));
    }

    protected function registered($request, $user)
    {
      $user->sendEmailActivationNotification();
      $this->guard()->logout();
      session_info("E-posta adresinize doğrulama kodu gönderilmiştir.");
      return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
          'first_name' => 'required|max:255',
          'last_name' => 'required|max:255',
          'email' => 'required|max:255|unique:users|email',
          'password' => 'required|min:6|confirmed',
          'faculty_id' => 'required',
          'birthday' => 'required|max:255',
          'mobile' => 'required|max:255',
          'year' => 'required|max:255',
          'title' => 'required|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => str_replace(' ', '', $data['email']),
            'password' => bcrypt($data['password']),
            'birthday' => $data['birthday'],
            'faculty_id' => intval($data['faculty_id']),
            'mobile' => substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $data['mobile']), -10),
            'year' => $data['year'],
            'title' => $data['title'],

        ]);
    }
}
