<?php

namespace Modules\Artist\Request;

use Core\Facades\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Artist\Repository\Contracts\ArtistRepository;

class FormCreateArtist extends FormRequest
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
            'name' => ['required', 'min:5', 'max:255', Rule::make(ArtistRepository::class, 'exists', config('artist.label.EXISTED_NAME'))],
            'slug' => ['required', 'min:5', 'max:255', Rule::make(ArtistRepository::class, 'exists', config('artist.label.EXISTED_SLUG'))],
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
            'name.required' => 'Tên danh mục không được bỏ trống',
            'name.min' => 'Tên danh mục tối thiểu 5 kí tự.',
            'name.max' => 'Tên danh mục tối đa 255 kí tự.',
            'slug.required' => 'Đường dẫn hiển thị không được bỏ trống',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 5 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
        ];
    }
}
