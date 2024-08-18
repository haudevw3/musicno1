<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormUpdateCategory extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|except:categories,name|min:5|max:255',
            'slug' => 'required|except:categories,slug|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'name.except' => 'Tên danh mục đã tồn tại.',
            'name.min' => 'Tên danh mục tối thiểu 6 kí tự.',
            'name.max' => 'Tên danh mục tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
