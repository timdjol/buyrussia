<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function trends($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 52))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')   // на случай дублей
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function category_posts($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 53))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')   // на случай дублей
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function pasts($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 51))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')   // на случай дублей
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

    public function editors($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 55))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }
}
