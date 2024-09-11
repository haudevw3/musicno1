<?php

namespace Modules\Categories\Request;

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
            'name' => 'min:5|max:255|except:categories,name',
            'slug' => 'min:5|max:255|except:categories,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Tên danh mục tối thiểu 6 kí tự.',
            'name.max' => 'Tên danh mục tối đa 255 kí tự.',
            'name.except' => 'Tên danh mục đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
        ];
    }
}
