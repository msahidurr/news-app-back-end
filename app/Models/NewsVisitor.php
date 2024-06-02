<?php

namespace App\Models;

use App\Models\BaseModel;

class NewsVisitor extends BaseModel
{
    protected $fillable = [
        'news_id',
        'user_id',
        'visitor',
    ];
}
