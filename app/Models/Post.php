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
        'comment'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
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
