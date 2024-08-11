<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormUpdatePlaylist extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|except:playlists,name|min:6|max:255',
            'slug' => 'required|except:playlists,slug|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh sách phát không được bỏ trống.',
            'name.except' => 'Tên danh sách phát đã tồn tại.',
            'name.min' => 'Tên danh sách phát tối thiểu 6 kí tự.',
            'name.max' => 'Tên danh sách phát tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
