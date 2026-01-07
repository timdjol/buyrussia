<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'code',
        'description',
        'category_id',
        'tag_id',
        'description',
        'image',
        'user_id',
        'lat',
        'lng',
        'images',
        'address',
        'graph',
        'comment',
        'phone',
        'url',
        'region_id',
        'company_id',
        'type',
        'kind'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function region()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'region_id');
    }
    public function company()
    {
        return $this->belongsTo(\App\Models\Tag::class, 'company_id');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): string
    {
        // Заглушка
        $fallback = asset('img/noimage.svg');

        if (! $this->image) {
            return $fallback;
        }

        // 1. Нормализуем путь
        $path = trim($this->image);

        // убираем домен, если вдруг попал
        $path = preg_replace('#^https?://[^/]+/#', '', $path);

        // убираем ведущий /
        $path = ltrim($path, '/');

        // 2. Приводим старый upload → news/photo
        if (str_starts_with($path, 'upload/')) {
            $path = str_replace('upload/', 'news/photo/', $path);
        }

        // 3. Проверка в public/
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // 4. Проверка в storage/app/public
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        // 5. Заглушка
        return $fallback;
    }


}
