<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Координаты: запятая -> точка
        $lat = $this->input('lat');
        $lng = $this->input('lng');

        // Нормализуем category_id: принимаем и массив, и одиночное значение
        $cid = $this->input('category_id');

        if (is_null($cid)) {
            $cid = [];
        } elseif (!is_array($cid)) {
            $cid = [$cid]; // на случай, если по ошибке прилетит скаляр
        }

        // чистим, приводим к int и убираем дубли
        $cid = array_values(array_unique(array_map(
            fn($v) => (int) $v,
            array_filter($cid, fn($v) => $v !== '' && $v !== null)
        )));

        $this->merge([
            'lat'         => is_null($lat) ? null : str_replace(',', '.', $lat),
            'lng'         => is_null($lng) ? null : str_replace(',', '.', $lng),
            'category_id' => $cid,
        ]);
    }

    public function rules(): array
    {
        return [
            'title'         => ['required','string','min:3','max:255'],

            // чекбоксы: массив ID категорий
            'category_id'   => ['required','array','min:1'],
            'category_id.*' => ['integer','distinct','exists:category_organizations,id'],

            'description'   => ['required','string','min:3'],

            // изображение (SVG надёжнее через file+mimetypes)
            'image' => ['nullable','file','mimetypes:image/jpeg,image/png,image/gif,image/webp,image/avif,image/svg+xml','max:2048'],

            'lat' => ['nullable','numeric','between:-90,90'],
            'lng' => ['nullable','numeric','between:-180,180'],

            'address' => ['nullable','string'],
            'graph'   => ['nullable','string'],
            'comment' => ['nullable','string'],

            // user_id ставим в контроллере
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для ввода',

            'title.min'       => 'Название должно иметь минимум :min символов',
            'description.min' => 'Описание должно иметь минимум :min символов',

            // ВАЖНО: сообщения под массив, а не под integer
            'category_id.required' => 'Нужно выбрать хотя бы одну категорию',
            'category_id.array'    => 'Категории должны быть массивом',
            'category_id.min'      => 'Нужно выбрать хотя бы одну категорию',
            'category_id.*.integer'  => 'Некорректный формат категории',
            'category_id.*.distinct' => 'Повторяющиеся категории не допускаются',
            'category_id.*.exists'   => 'Выбрана несуществующая категория',

            'image.mimetypes' => 'Недопустимый тип файла изображения.',
            'image.max'       => 'Изображение не должно превышать :max КБ.',

            'lat.numeric' => 'Широта должна быть числом (используйте точку как разделитель).',
            'lat.between' => 'Широта должна быть в диапазоне от -90 до 90.',
            'lng.numeric' => 'Долгота должна быть числом (используйте точку как разделитель).',
            'lng.between' => 'Долгота должна быть в диапазоне от -180 до 180.',
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
