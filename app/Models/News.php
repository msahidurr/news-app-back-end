<?php

namespace App\Models;

use App\Models\BaseModel;

class News extends BaseModel
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'author',
        'status',
        'created_by',
        'published_by',
        'published_at',
    ];

    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'content' => 'string',
        'author' => 'string',
        'status' => 'boolean',
        'created_by' => 'integer',
        'published_by' => 'integer',
        'published_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class, 'news_category_maps', 'news_id', 'news_category_id')->active();
    }

    public function visit()
    {
        return $this->hasOne(NewsVisitor::class);
    }
}
