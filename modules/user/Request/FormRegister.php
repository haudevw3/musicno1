<?php

namespace Modules\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class FormRegister extends FormRequest
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
            'name' => 'required|min:6|max:50',
            'username' => ['required', 'min:6', 'max:30', new \Core\Rules\UserExists],
            'password' => 'required|min:8|max:30',
            'email' => ['required', 'email', new \Core\Rules\EmailExists],
        ];
    }

    /**
     * Get the messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Họ và tên không được bỏ trống.',
            'name.min' => 'Họ và tên tối thiểu 6 kí tự.',
            'name.max' => 'Họ và tên tối đa 50 kí tự.',
            'username.required' => 'Tên đăng nhập không được bỏ trống.',
            'username.min' => 'Tên đăng nhập tối thiểu 6 kí tự.',
            'username.max' => 'Tên đăng nhập tối đa 30 kí tự.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu tối thiểu 8 kí tự.',
            'password.max' => 'Mật khẩu tối đa 30 kí tự.',
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không đúng định dạng.',
        ];
    }
}
