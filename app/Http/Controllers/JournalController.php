<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function travels($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 57))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

    public function populars($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 58))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

    public function posts($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [4,56,59]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }
}
