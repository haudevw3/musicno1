<?php

namespace Modules\Categories\Request;

use Core\Facades\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Categories\Repository\Contracts\CategoryRepository;

class FormUpdateCategory extends FormRequest
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
            'name' => ['min:5', 'max:255', Rule::make(CategoryRepository::class, 'except', config('categories.label.EXISTED_NAME'), $this)],
            'slug' => 'min:5|max:255',
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
            'name.min' => 'Tên danh mục tối thiểu 5 kí tự.',
            'name.max' => 'Tên danh mục tối đa 255 kí tự.',
            'slug.min' => 'Đường dẫn hiển thị tối thiểu 5 kí tự.',
            'slug.max' => 'Đường dẫn hiển thị tối đa 255 kí tự.',
            'priority.integer' => 'Độ ưu tiên danh mục phải là một số.',
        ];
    }
}
