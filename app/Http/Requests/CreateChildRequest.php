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
            'meeting_text'     => 'required',
            'verification_doc' => 'image',
            'users'            => 'required'
        ];
    }
}
