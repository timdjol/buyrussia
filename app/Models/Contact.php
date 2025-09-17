<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'description',
        'facebook',
        'twitter',
        'talk',
        'blogger',
        'youtube',
        'address',
        'phone',
        'email',
        'ban',
        'link_ban',
        'ban2',
        'link_ban2',
        'ban3',
        'link_ban3',
        'ban4',
        'link_ban4'
    ];
}
