<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function russia($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [109,113,114,115,116,117,118,119,120]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function kg($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [110,121,122,123,124,125,126,127]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function kz($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [111,129,130,131,132,133,134,135]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function uz($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [112,136,137,138,139,140,141]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }
}
