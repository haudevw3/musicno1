<?php

namespace Modules\Adm\Request;

use Foundation\Http\FormRequest;

class FormUpdateArtist extends FormRequest
{
    public function authorized()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|except:artists,name|min:6|max:255',
            'slug' => 'required|except:artists,slug|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên nghệ sĩ không được bỏ trống.',
            'name.except' => 'Tên nghệ sĩ đã tồn tại.',
            'name.min' => 'Tên nghệ sĩ tối thiểu 6 kí tự.',
            'name.max' => 'Tên nghệ sĩ tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống.',
            'slug.except' => 'Đường dẫn hiển thị đã tồn tại.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 6 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
