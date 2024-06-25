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
            'name' => 'except:categories,name|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Tên danh mục thiểu 6 kí tự.',
            'name.max' => 'Tên danh mục đa 255 kí tự.',
        ];
    }
}
