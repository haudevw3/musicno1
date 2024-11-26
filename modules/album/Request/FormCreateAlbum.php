<?php

namespace Modules\Album\Request;

use Core\Facades\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Album\Repository\Contracts\AlbumRepository;

class FormCreateAlbum extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:5', 'max:255', Rule::make(AlbumRepository::class, 'exists', config('album.label.EXISTED_NAME'))],
            'slug' => ['required', 'min:5', 'max:255', Rule::make(AlbumRepository::class, 'exists', config('album.label.EXISTED_SLUG'))],
            'album_type' => 'required',
            'release_year' => ['required', 'integer'],
        ];
    }

    /**
     * Get the messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên album không được bỏ trống.',
            'name.min' => 'Tên album tối thiểu 5 kí tự.',
            'name.max' => 'Tên album tối đa 255 kí tự.',
            'slug.required' => 'Tên đường dẫn không được bỏ trống.',
            'slug.min' => 'Tên đường dẫn tối thiểu 5 kí tự.',
            'slug.max' => 'Tên đường dẫn tối đa 255 kí tự.',
            'album_type.required' => 'Loại album không được bỏ trống.',
            'release_year.required' => 'Năm phát hành album không được bỏ trống.',
            'release_year.integer' => 'Năm phát hành album phải là một số.',
        ];
    }
}
