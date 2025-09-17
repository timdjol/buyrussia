<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Ad;
use App\Models\Blogger;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Vantage;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $news = Post::latest()->get()->take(6);
        $journals = Post::whereIn('category_id', [5,56,57,58,59])->latest()->take(6)->get();
        $agency = Post::whereIn('category_id', [8,104,105,106,107,108])->latest()->take(6)->get();
        $advs = Post::where('category_id', 106)->latest()->take(10)->get();
        $business = Post::where('category_id', 107)->latest()->take(10)->get();
        $vantages = Vantage::all();
        $videos = Video::all();
        $bloggers = Blogger::all();

        return view('index', compact('sliders', 'news', 'journals', 'agency', 'business', 'vantages', 'videos', 'bloggers', 'advs'));
    }

    public function category($category)
    {
        $posts = Category::find($category)->posts->sortByDesc('created_at')->unique('id')->take(20);
        return view('pages.category', compact('posts', 'category'));
    }

    public function tag($id)
    {
        $tag = Tag::where('id', $id)->first();
        return view('pages.tag', compact('tag'));
    }

    public function post($category, $id)
    {
        $post = Post::where('id', $id)->firstOrFail();
        $related = Post::where('id', '!=', $id)->latest()->take(8)->get();
        $user = Auth::user();
        $comments = Comment::where('post_id', $id)->latest()->get();
        return view('pages.post', compact('post', 'related', 'user', 'comments'));
    }

    public function ad($id)
    {
        $ad = Ad::where('id', $id)->firstOrFail();
        return view('pages.ad', compact('ad'));
    }

    public function storeComment(CommentRequest $request)
    {
        $params = $request->all();
        Comment::create($params);
        session()->flash('success', 'Comment ' . $request->title . ' created');

        return back();
    }

    public function news()
    {
        $main = Post::latest()->take(1)->get();
        $maint = Post::latest()->take(2)->offset(1)->get();
        $categories = Category::take(4)->get();
        $trends = Post::where('category_id', 52)->latest()->take(2)->get();
        $latest = Post::where('category_id', 54)->latest()->take(4)->get();
        $latestlist = Post::where('category_id', 54)->latest()->take(6)->offset(4)->get();
        $featured = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 55))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')   // на случай дублей
            ->take(4)
            ->get();

        return view('pages.news', compact('main', 'maint', 'trends', 'latest', 'latestlist', 'featured', 'categories'));
    }

    public function journals()
    {
        $journals = Post::whereIn('category_id', [5,56,57,58,59])->latest()->take(2)->get();
        $tjournals = Post::whereIn('category_id', [5,56,57,58,59])->latest()->skip(2)->take(3)->get();
        $travels = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 57))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')   // на случай дублей
            ->take(6)
            ->get();
        $populars = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->where('categories.id', 58))
            ->latest('posts.created_at')
            ->select('posts.*')
            ->distinct('posts.id')   // на случай дублей
            ->take(4)
            ->get();
        $mjournals = Post::whereIn('category_id', [5,56,57,58,59])->latest()->skip(5)->take(2)->get();
        $ljournals = Post::whereIn('category_id', [5,56,57,58,59])->latest()->skip(7)->take(16)->get();
        return view('pages.journal', compact('journals', 'tjournals', 'travels', 'populars', 'mjournals', 'ljournals'));
    }

    public function organizations()
    {
        $sliders = Slider::all();
        $institutions = Post::whereIn('category_id', [32,37,42,47])->latest()->take(8)->get();
        $kor_orgs = Post::whereIn('category_id', [33,45,50,38])->latest()->take(8)->get();
        $edus = Post::whereIn('category_id', [34,48,39,43])->latest()->take(8)->get();
        $medias = Post::whereIn('category_id', [35,49,40,44])->latest()->take(8)->get();

        return view('pages.organization', compact('sliders', 'institutions', 'kor_orgs', 'edus', 'medias'));
    }

    public function business()
    {
        $rests = Post::with('categories:id') // чтобы не было N+1
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [61,66,67,65]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $hotels = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [71,69,70,68]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $sports = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [76,77,78,79]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $medical = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [80,81,82,83]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $tourism = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [84,85,86,87]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $edus = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [88,89,90,91]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $laws = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [92,93,94,95]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $karaoke = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [72,73,74,75]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $beauty = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [96,97,98,99]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $academies = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [100,101,102,103]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        return view('pages.business', compact('rests', 'hotels', 'sports', 'medical', 'tourism', 'edus', 'laws', 'karaoke', 'beauty', 'academies'));
    }

    public function community()
    {
        $ads = Ad::paginate(20);
//        $ads = Post::with('categories:id')
//            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [8,104,105,106,107,108]))
//            ->select('posts.*')
//            ->latest('posts.created_at')
//            ->distinct('posts.id')
//            ->take(12)
//            ->get();
        return view('pages.community', compact('ads'));
    }

    public function travel()
    {
        $russia = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [109,113,114,115,116,117,118,119,120]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        $kg = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [110,121,122,123,124,125,126,127]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        $kz= Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [111,129,130,131,132,133,134,135]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();

        $uz = Post::with('categories:id')
            ->whereHas('categories', fn($q) => $q->whereIn('categories.id', [112,136,137,138,139,140,141]))
            ->select('posts.*')
            ->latest('posts.created_at')
            ->distinct('posts.id')
            ->take(12)
            ->get();
        return view('pages.travel', compact('russia', 'kg', 'uz', 'kz'));
    }

    public function search()
    {
        $title = $_GET['title'];
        $search = Post::query()
            ->where('title', 'like', '%' . $title . '%')
            ->orWhere('description', 'like', '%' . $title . '%')
            ->get();
        return view('pages.search', compact('search'));
    }

    public function searchad()
    {
        $title = $_GET['title'];
        $search = Ad::query()
            ->where('title', 'like', '%' . $title . '%')
            ->orWhere('description', 'like', '%' . $title . '%')
            ->get();
        return view('pages.searchad', compact('search'));
    }

    public function createAd()
    {
        return view('pages.adform');
    }

    public function storeAd(AdRequest $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        Ad::create($params);

        session()->flash('success', 'Ad ' . $request->title . ' created');
        $ads = Ad::paginate(20);
        return view('pages.community', compact('ads'));
    }

    public function page()
    {
        return view('pages.page');
    }
}
