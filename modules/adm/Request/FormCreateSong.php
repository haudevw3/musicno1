<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormCreateSong extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|exists:songs,name|min:6|max:255',
            'slug' => 'required|exists:songs,slug|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên bài hát không được bỏ trống.',
            'name.exists' => 'Tên bài hát đã tồn tại.',
            'name.min' => 'Tên bài hát tối thiểu 6 kí tự.',
            'name.max' => 'Tên bài hát tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống.',
            'slug.exists' => 'Đường dẫn hiển thị đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
