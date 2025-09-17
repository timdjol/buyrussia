<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|min:3',
            'category' => 'required',
            'description' => 'required|min:3',
        ];

        return $rules;
    }

    public function messages()
    {
        return[
            'required'=>'The :attribute field is required.',
            'min' => 'The :attribute field must have at least :min characters.',
        ];
    }
}
