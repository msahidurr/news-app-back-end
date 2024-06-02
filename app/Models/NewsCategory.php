<?php

namespace App\Models;

use App\Models\BaseModel;

class NewsCategory extends BaseModel
{
    protected $fillable = [
        'title',
        'slug',
    ];
}
