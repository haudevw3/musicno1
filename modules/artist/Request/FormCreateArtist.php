<?php

namespace Modules\Artist\Request;

use Foundation\Http\FormRequest;

class FormCreateArtist extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'min:6|max:255|exists:artists,name',
            'slug' => 'min:6|max:255|exists:artists,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Tên nghệ sĩ tối thiểu 6 kí tự.',
            'name.max' => 'Tên nghệ sĩ tối đa 255 kí tự.',
            'name.exists' => 'Tên nghệ sĩ đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
            'slug.exists' => 'Đường dẫn hiển thị đã tồn tại.',
        ];
    }
}