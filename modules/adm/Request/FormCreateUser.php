<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormCreateUser extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fullname' => 'required|min:6|max:50',
            'username' => 'required|exists:users,username|min:6|max:30',
            'password' => 'required|min:6|max:30',
            'email' => 'required|min:6|email',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Họ và tên không được bỏ trống.',
            'fullname.min' => 'Họ và tên tối thiểu 6 kí tự.',
            'fullname.max' => 'Họ và tên tối đa 50 kí tự.',
            'username.required' => 'Tên đăng nhập không được bỏ trống.',
            'username.exists'=> 'Tên đăng nhập đã tồn tại.',
            'username.min' => 'Tên đăng nhập tối thiểu 6 kí tự.',
            'username.max' => 'Tên đăng nhập tối đa 30 kí tự.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự.',
            'password.max' => 'Mật khẩu tối đa 30 kí tự.',
            'email.required' => 'Email không được bỏ trống.',
            'email.min' => 'Email tối thiểu 6 kí tự.',
            'email.email' => 'Email không đúng định dạng.',
            'role.required' => 'Vai trò không được bỏ trống.',
        ];
    }
}
