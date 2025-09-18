<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'company_id'
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


}
