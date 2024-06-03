<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    public function index(Request $request)
    {
        $news = News::published()
            ->with('author', 'categories', 'tags')
            ->when($search = $request->search, function($query) use ($search) {
                $query->where(function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($categoryId = $request->category_id, function($query) use ($categoryId) {
                $query->whereHas('categories', function($query) use ($categoryId) {
                    $query->whereIn('news_categories.id', explode(',', $categoryId));
                });
            })
            ->when($tag = $request->tag, function($query) use ($tag) {
                $query->whereHas('tags', function($query) use ($tag) {
                    $query->whereIn('news_tags.slug', explode(',', $tag));
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate()
            ->map(function($row) {
                return [
                    'id'            => $row->id,
                    'title'         => $row->title,
                    'content'       => $row->content,
                    'image'         => null,
                    'video'         => null,
                    'author'        => $row->author->name ?? null,
                    'author_avatar' => $row->author->avatar ?? null,
                    'status'        => $row->status,
                    'status_label'  => $row->statusLabel(),
                    'published_at'  => optional($row->published_at)->diffForHumans() ?? null,
                    'categories'    => $row->categories->map(function($row) {
                        return [
                            'id'    => $row->id,
                            'title' => $row->title,
                            'slug'  => $row->slug,
                        ];
                    }),
                ];
            });
        
        if(count($news) > 0) {
            return response()->json([
                'message'  => 'Success',
                'data'  => $news,
            ], 200);
        }

        return response()->json([
            'message'  => 'Not found',
            'data'  => null,
        ], 404);
    }

    public function show(Request $request, $id)
    {
        $news = News::published()
            ->with('author', 'categories:id,title,slug', 'tags:id,title,slug')
            ->orderBy('created_at', 'desc')
            ->when($categoryId = $request->category_id, function($query) use ($categoryId) {
                $query->whereHas('categories', function($query) use ($categoryId) {
                    $query->whereIn('news_categories.id', explode(',', $categoryId));
                });
            })
            ->when($tag = $request->tag, function($query) use ($tag) {
                $query->whereHas('tags', function($query) use ($tag) {
                    $query->whereIn('news_tags.slug', explode(',', $tag));
                });
            })
            ->whereId($id)
            ->get()
            ->map(function($row) {
                return [
                    'id'            => $row->id,
                    'title'         => $row->title,
                    'content'       => $row->content,
                    'image'         => null,
                    'video'         => null,
                    'author'        => $row->author->name ?? null,
                    'author_avatar' => $row->author->avatar ?? null,
                    'status'        => $row->status,
                    'status_label'  => $row->statusLabel(),
                    'published_at'  => optional($row->published_at)->diffForHumans() ?? null,
                    'categories'    => $row->categories->map(function($row) {
                        return [
                            'id'    => $row->id,
                            'title' => $row->title,
                            'slug'  => $row->slug,
                        ];
                    }),
                ];
            });

        if(isset($news[0])) {

            News::visitCreate([
                'news_id' => $news[0]->id,
                'user_id' => $request->user()->id,
                'visitor' => $request->ip_address,
            ]);

            return response()->json([
                'message'  => 'Success',
                'data'  => $news[0],
            ], 200);
        }

        return response()->json([
            'message'  => 'Not found',
            'data'  => null,
        ], 404);
    }
}
