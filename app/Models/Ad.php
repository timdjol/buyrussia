<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
