<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Blogger;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Vantage;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-page|edit-page|delete-page', ['only' => ['index','show']]);
        $this->middleware('permission:create-page', ['only' => ['create','store']]);
        $this->middleware('permission:edit-page', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-page', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('auth.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.pages.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        Page::create($params);
        session()->flash('success', 'Page ' . $request->title . ' created');
        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Page $page)
    {
        return view('auth.pages.form', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        $page->update($params);
        session()->flash('success', 'Page ' . $request->title . ' updated');

        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        session()->flash('success', 'Page ' . $page->title . ' deleted');
        return redirect()->route('pages.index');
    }

    public function dashboard()
    {
        $posts = Post::all();
        $categories = Category::all();
        $tags = Tag::all();
        $comments = Comment::all();
        $ads = Ad::all();
        $pages = Page::all();
        $sliders = Slider::all();
        $vantages = Vantage::all();
        $videos = Video::all();
        $bloggers = Blogger::all();

        return view('auth.dashboard', compact('posts', 'pages', 'categories', 'tags', 'comments', 'ads', 'sliders', 'vantages', 'videos',
        'bloggers'));
    }

    public function uploadMedia(Request $request)
    {
        try {
            $path = $request->file('upload')->store('public/images');
            $url = Storage::url($path);

            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'uploaded' => false,
                    'error'    => [
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }


}



