<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('category')?->id;

        return [
            'title'     => ['required','string','max:255'],
            'image'     => ['nullable','image'],
            'parent_id' => [
                'nullable','integer','exists:categories,id',
                function($attr,$value,$fail) use ($id) {
                    if ($id && Category::hasCycle($id, (int)$value)) {
                        $fail('Нельзя выбирать потомка как родителя (получится цикл).');
                    }
                },
            ],
        ];
    }
}
