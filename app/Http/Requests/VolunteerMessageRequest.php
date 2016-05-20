<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VolunteerMessageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'email'=>'required|email|max:255',
            'mobile'=>'required|max:255',
            'city'=>'required|max:255',
            'child_id'=>'required',
            'text'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'=>'İsim boş bırakılamaz',
            'first_name.max'=>'İsim en fazla 255 karakter olabilir',
            'last_name.required'=>'Soyad boş bırakılamaz',
            'last_name.max'=>'Soyad en fazla 255 karakter olabilir',
            'email.required'=>'E-posta adresi boş bırakılamaz',
            'email.max'=>'E-posta en fazla 255 karakterden oluşabilir',
            'email.email'=>'Lütfen geçerli bir e-posta adresi giriniz',
            'mobile.required'=>'Telefon numarası boş bırakılamaz',
            'mobile.max'=>'Telefon numarası en fazla 255 karakter olabilir',
            'city.required'=>'Şehir boş bırakılamaz',
            'city.max'=>'Şehir en fazla 255 karakter olabilir',
            'text.required'=>'Mesaj kısmını boş bırakamazsınız.',
        ];
    }
}
