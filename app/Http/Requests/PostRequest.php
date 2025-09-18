<?php

namespace App\Http\Requests;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Нормализуем десятичные запятые → точки перед валидацией
    protected function prepareForValidation(): void
    {
        $this->merge([
            'region_id'  => $this->normalizeSelectId($this->input('region_id')),
            'company_id' => $this->normalizeSelectId($this->input('company_id')),
        ]);
    }

    private function normalizeSelectId($value): ?int
    {
        if ($value === '' || $value === null) return null;
        if (is_numeric($value)) return (int)$value;

        if (is_string($value) && str_starts_with($value, '__new__:')) {
            $text = trim(substr($value, 9));
            if ($text === '') return null;

            // создаём тег тем же методом, что и в store_tag
            $existing = Tag::where('title', $text)->first();
            if ($existing) return (int)$existing->id;

            // если в модели timestamps выключены — можно Tag::create
            // иначе — прямой insert:
            $id = DB::table('tags')->insertGetId(['title' => $text /*,'created_at'=>now(),'updated_at'=>now()*/]);
            return (int)$id;
        }
        return null;
    }


    public function rules(): array
    {
        return [
            'title'         => 'required|string',
            'category_id'   => 'required','array','min:1',
            'category_id.*' => 'integer','distinct','exists:categories,id',
            'region_id'  => 'nullable',
            'company_id' => ['nullable'],
            'description'   => ['required','string','min:3'],
            'image'   => ['nullable','image','mimes:jpeg,png,jpg,gif,svg,webp,avif','max:2048'],
            'user_id' => ['required','exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для ввода',
            'title.min'       => 'Название должно иметь минимум :min символов',
            'description.min' => 'Описание должно иметь минимум :min символов',
            'category_id.required' => 'Нужно выбрать хотя бы одну категорию',
            'category_id.array'    => 'Некорректный формат категорий',
            'category_id.min'      => 'Нужно выбрать хотя бы одну категорию',
            'category_id.*.exists' => 'Выбрана несуществующая категория',
            'category_id.*.distinct' => 'Повторяющиеся категории не допускаются',
        ];
    }

    public function attributes(): array
    {
        return [
            'title'       => 'Название',
            'description' => 'Описание',
            'category_id' => 'Категории',
            'image'       => 'Изображение',
        ];
    }
}
