<?php

namespace Modules\Categories\Request;

use Core\Facades\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Categories\Repository\Contracts\CategoryRepository;

class FormCreateCategory extends FormRequest
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
            'name' => ['required', 'min:5', 'max:255', Rule::make(CategoryRepository::class, 'exists', config('categories.label.EXISTED_NAME'))],
            'slug' => ['required', 'min:5', 'max:255', Rule::make(CategoryRepository::class, 'exists', config('categories.label.EXISTED_SLUG'))],
            'priority' => 'integer',
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
            'name.required' => 'Tên danh mục không được bỏ trống.',
            'name.min' => 'Tên danh mục tối thiểu 5 kí tự.',
            'name.max' => 'Tên danh mục tối đa 255 kí tự.',
            'slug.required' => 'Tên đường dẫn không được bỏ trống.',
            'slug.min' => 'Tên đường dẫn tối thiểu 5 kí tự.',
            'slug.max' => 'Tên đường dẫn tối đa 255 kí tự.',
            'priority.integer' => 'Độ ưu tiên danh mục phải là một số.',
        ];
    }
}
