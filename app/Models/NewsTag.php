<?php

namespace App\Models;

use App\Models\BaseModel;

class NewsTag extends BaseModel
{
    protected $fillable = [
        'title',
        'slug',
        'active',
    ];
}
