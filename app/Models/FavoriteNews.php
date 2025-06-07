<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteNews extends Model
{
    protected $fillable = [
        'news_id',
        'user_id',
    ];
}
