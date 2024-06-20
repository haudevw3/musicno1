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
            'name' => 'exists:categories,name|min:6|max:255',
            'slug' => 'min:6|max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.min'    => 'Họ và tên tối thiểu 6 kí tự.',
            'name.max'    => 'Họ và tên tối đa 255 kí tự.',
            'slug.min'    => 'Họ và tên tối thiểu 6 kí tự.',
            'slug.max'    => 'Họ và tên tối đa 255 kí tự.',
        ];
    }
}
