<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
