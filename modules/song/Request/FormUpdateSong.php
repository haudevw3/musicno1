<?php

namespace Modules\Song\Request;

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
            'name' => 'min:6|max:255|except:songs,name',
            'slug' => 'min:6|max:255|except:songs,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Tên bài hát tối thiểu 6 kí tự.',
            'name.max' => 'Tên bài hát tối đa 255 kí tự.',
            'name.except' => 'Tên bài hát đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
        ];
    }
}
