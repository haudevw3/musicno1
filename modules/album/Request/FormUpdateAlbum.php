<?php

namespace Modules\Album\Request;

use Foundation\Http\FormRequest;

class FormUpdateAlbum extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'min:6|max:255|except:albums,name',
            'slug' => 'min:6|max:255|except:albums,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Tên album tối thiểu 6 kí tự.',
            'name.max' => 'Tên album tối đa 255 kí tự.',
            'name.except' => 'Tên album đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
        ];
    }
}
