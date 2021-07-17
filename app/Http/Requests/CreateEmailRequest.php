<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $rules = [
            'email'   => 'required|email|unique:users',

        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập địa chỉ mail',
            'email.email'    => 'Email không đúng',
            'email.unique'   => 'Email đã tồn tại !',
        ];
    }
}
