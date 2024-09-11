<?php

namespace Modules\Playlist\Request;

use Foundation\Http\FormRequest;

class FormCreatePlaylist extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'min:6|max:255|exists:playlists,name',
            'slug' => 'min:6|max:255|exists:playlists,slug',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Tên danh sách phát tối thiểu 6 kí tự.',
            'name.max' => 'Tên danh sách phát tối đa 255 kí tự.',
            'name.exists' => 'Tên danh sách phát đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
            'slug.exists' => 'Đường dẫn hiển thị đã tồn tại.',
        ];
    }
}
