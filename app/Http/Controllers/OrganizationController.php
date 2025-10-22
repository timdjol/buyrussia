<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function organizations($category=null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [32,37,42,47]))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

    public function korean($category=null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [33,45,50,38]))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

    public function education($category=null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [34,48,39,43]))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

    public function media($category=null)
    {
        $posts = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [35,49,40,44]))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')
            ->get();
        return view('pages.posts', compact('posts', 'category'));
    }

}
