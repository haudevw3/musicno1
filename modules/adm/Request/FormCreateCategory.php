<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormCreateCategory extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|exists:categories,name|min:5|max:255',
            'slug' => 'required|exists:categories,slug|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'name.exists' => 'Tên danh mục đã tồn tại.',
            'name.min' => 'Tên danh mục tối thiểu 6 kí tự.',
            'name.max' => 'Tên danh mục tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống.',
            'slug.exists' => 'Đường dẫn hiển thị đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
