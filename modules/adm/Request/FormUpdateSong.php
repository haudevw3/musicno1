<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormUpdateSong extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|except:song,name|min:6|max:255',
            'slug' => 'required|except:song,slug|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên bài hát không được bỏ trống.',
            'name.except' => 'Tên bài hát đã tồn tại.',
            'name.min' => 'Tên bài hát tối thiểu 6 kí tự.',
            'name.max' => 'Tên bài hát tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
