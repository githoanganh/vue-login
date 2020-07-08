<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'nickname' => 'required|unique:users',
            'password' => 'required|confirmed'
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'Bạn chưa nhập First Name',
            'last_name.required' => 'Bạn chưa nhập Last Name',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Địa chỉ email không đúng',
            'email.unique' => 'Địa chỉ email đã tồn tại',
            'nickname.required' => 'Bạn chưa nhập nickname',
            'nickname.unique' => 'Nickname đã tồn tại',
            'password.required' => 'Bạn chưa nhập password',
            'password.comfirmed' => 'Password không trùng khớp'
        ];
    }
}
