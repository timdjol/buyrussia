<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Нормализуем десятичные запятые → точки перед валидацией
    protected function prepareForValidation(): void
    {
        $lat = $this->input('lat');
        $lng = $this->input('lng');

        $this->merge([
            'lat' => is_null($lat) ? null : str_replace(',', '.', $lat),
            'lng' => is_null($lng) ? null : str_replace(',', '.', $lng),
        ]);
    }

    public function rules(): array
    {
        $postId = $this->route('post')?->id;

        $titleRule = 'required|string|min:3|max:255|unique:posts,title';
        if ($postId) {
            $titleRule .= ',' . $postId;
        }

        return [
            'title'         => $titleRule,

            // если категория обязательна → required|min:1, иначе nullable
            'category_id'   => ['required','array','min:1'],
            'category_id.*' => ['integer','distinct','exists:categories,id'],

            'description'   => ['required','string','min:3'],

            'image'   => ['nullable','image','mimes:jpeg,png,jpg,gif,svg,webp,avif','max:2048'],

            // КООРДИНАТЫ: только числовые + диапазоны, НИКАКИХ min:3
            'lat'     => ['nullable','numeric'],
            'lng'     => ['nullable','numeric'],

            'address' => ['nullable','string'],
            'graph'   => ['nullable','string'],
            'comment' => ['nullable','string'],

            // если нужно обязательно — оставьте required
            'user_id' => ['required','exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для ввода',

            // Точные сообщения для строковых min
            'title.min'       => 'Название должно иметь минимум :min символов',
            'description.min' => 'Описание должно иметь минимум :min символов',

            // Категории
            'category_id.required' => 'Нужно выбрать хотя бы одну категорию',
            'category_id.array'    => 'Некорректный формат категорий',
            'category_id.min'      => 'Нужно выбрать хотя бы одну категорию',
            'category_id.*.exists' => 'Выбрана несуществующая категория',
            'category_id.*.distinct' => 'Повторяющиеся категории не допускаются',

            // Координаты — отдельные сообщения
            'lat.numeric'   => 'Широта должна быть числом (используйте точку как разделитель).',
            'lat.between'   => 'Широта должна быть в диапазоне от -90 до 90.',
            'lng.numeric'   => 'Долгота должна быть числом (используйте точку как разделитель).',
            'lng.between'   => 'Долгота должна быть в диапазоне от -180 до 180.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'Название',
            'description' => 'Описание',
            'category_id' => 'Категории',
            'image'       => 'Изображение',
            'lat'         => 'Широта',
            'lng'         => 'Долгота',
            'graph'       => 'Время',
            'address'     => 'Адрес',
            'comment'     => 'Основная информация',
        ];
    }
}
