<?php

namespace Modules\User\Request;

use Foundation\Http\FormRequest;

class FormRegister extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fullname' => 'min:6|max:50',
            'username' => 'min:6|max:30|exists:users,username',
            'password' => 'min:6|max:30',
            'email' => 'min:6|email|exists:users,email'
        ];
    }

    public function messages()
    {
        return [
            'fullname.min' => 'Họ và tên tối thiểu 6 kí tự.',
            'fullname.max' => 'Họ và tên tối đa là 50 kí tự.',
            'username.min' => 'Tên đăng nhập tối thiểu 6 kí tự.',
            'username.max' => 'Tên đăng nhập tối đa 30 kí tự.',
            'username.exists' => 'Tên đăng nhập đã tồn tại.',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự.',
            'password.max' => 'Mật khẩu tối đa 30 kí tự.',
            'email.min' => 'Email tối thiểu 6 kí tự.',
            'email.email' => 'Email không đúng định dạng.',
            'email.exists' => 'Email đã tồn tại.'
        ];
    }
}
