<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BusinessController extends Controller
{
    public function rests($category = null)
    {
        $posts = Post::with('categories:id')
        ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [61,66,67,65]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function hotels($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [71,69,70,68]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function sports($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [76,77,78,79]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function medical($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [80,81,82,83]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function tourism($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [84,85,86,87]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function edus($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [88,89,90,91]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function laws($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [92,93,94,95]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function karaoke($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [72,73,74,75]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function beauty($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [96,97,98,99]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }

    public function academies($category = null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [100,101,102,103]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        return view('pages.posts', compact('posts', 'category'));
    }
}
