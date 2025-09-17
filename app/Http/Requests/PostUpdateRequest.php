<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            //'code' => 'required|unique:posts,code',
            'title' => 'required|min:3|max:255',
            'category_id' => 'required',
            'description' => 'required|min:3',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'address' => 'nullable',
            'graph' => 'nullable',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'comment' => 'nullable',
            'user_id' => 'exists:users,id',
        ];
//        if($this->route()->named('categories.update')){
//            $rules['code'] .= ',' . $this->route()->parameter('category')->id;
//        }
        return $rules;
    }

    public function messages()
    {
        return[
            'required'=>'Поле :attribute обязательно для ввода',
            'min' => 'Поле :attribute должно иметь минимум :min символов',
            'code.min' => 'Поле код должно содержать не менее :min символов'
        ];
    }
}
