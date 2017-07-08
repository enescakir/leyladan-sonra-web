<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateChildRequest extends Request
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
            'department'       => 'required',
            'first_name'       => 'required',
            'last_name'        => 'required',
            'diagnosis'        => 'required',
            'diagnosis_desc'   => 'required',
            'meeting_day'      => 'required|date',
            'birthday'         => 'required|date',
            'wish'             => 'required',
            'g_first_name'     => 'required',
            'g_last_name'      => 'required',
            'g_mobile'         => 'required',
            'province'         => 'required',
            'city'             => 'required',
            'adress'           => 'required',
            'child_state'      => 'required',
            'child_state_desc' => 'required',
            'website_text'     => 'required',
            'website_image'    => 'required|image',
            'verification_doc' => 'image',
            'users'            => 'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'       =>'Ad boş bırakılamaz',
            'last_name.required'        =>'Soyad boş bırakılamaz',
            'department.required'       =>'Departman boş bırakılamaz',
            'diagnosis.required'        =>'Tanı boş bırakılamaz',
            'diagnosis_desc.required'   =>'Tanı açıklaması boş bırakılamaz',
            'meeting_day.required'      =>'Buluşma günü boş bırakılamaz',
            'birthday.required'         =>'Doğumgünü boş bırakılamaz',
            'wish.required'             =>'Dilek boş bırakılamaz',
            'g_first_name.required'     =>'Veli adı boş bırakılamaz',
            'g_last_name.required'      =>'Veli soyadı boş bırakılamaz',
            'g_mobile.required'         =>'Velinin telefonu boş bırakılamaz',
            'province.required'         =>'Velinin ilçesi boş bırakılamaz',
            'city.required'             =>'Velinin şehri boş bırakılamaz',
            'adress.required'           =>'Velinin adresi boş bırakılamaz',
            'child_state.required'      =>'Çocuğun durumunu seçiniz. Mavi butona basarak seçebilirsiniz.',
            'child_state_desc.required' =>'Çocuğun durumuna açıklama ekleyin',
            'website_text.required'     =>'Tanışma yazısı eklemeniz gerekiyor',
            'website_image.image'       =>'Geçerli bir resim yükleyin',
            'website_image.required'    =>'Resim eklemeniz gerekiyor.',
            'verification_doc.image'    =>'Onay formu için yüklenen dosya resim olmalı',
            'users.required'            =>'Çocuğun sorumlularını seçmeniz gerekiyor',

        ];
    }

}
