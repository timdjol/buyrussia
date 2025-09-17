<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'title',
        'code',
        'type'
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }
}
