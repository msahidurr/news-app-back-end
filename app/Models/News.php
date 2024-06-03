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
        'status' => 'integer',
        'created_by' => 'integer',
        'published_by' => 'integer',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function visit()
    {
        return $this->hasOne(NewsVisitor::class);
    }

    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class, 'news_category_maps', 'news_id', 'news_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(NewsTag::class, 'news_tag_maps', 'news_id', 'news_tag_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 3);
    }

    public function statusLabel()
    {
        return [
            1 => 'Draft',
            2 => 'Pending',
            3 => 'Published',
            4 => 'Change request',
            5 => 'Reject',
        ][$this->status];
    }

    public static function visitCreate(array $request)
    {
        return NewsVisitor::create($request);
    }
}
