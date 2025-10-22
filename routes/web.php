<?php

use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\PageController::class, 'dashboard'])->name('dashboard');
    Route::post('posts/uploadMedia', [\App\Http\Controllers\Admin\PageController::class, 'uploadMedia'])->name('uploadMedia');
    Route::get('/logout', [\App\Http\Controllers\Admin\PageController::class, 'logout'])->name('get-logout');

    Route::get('/tags/search', [PageController::class, 'search_tag'])->name('tags.search');
    Route::post('/tags',       [PageController::class, 'store_tag'])->name('tags.store');

    Route::resource("categories", "App\Http\Controllers\Admin\CategoryController");
    Route::resource("taglists", "App\Http\Controllers\Admin\TagController")->parameters(['taglists' => 'tag']); ;
    Route::resource("posts", "App\Http\Controllers\Admin\PostController");
    Route::resource('organizations', OrganizationController::class)->parameters(['organizations' => 'post']);
    Route::resource("comments", "App\Http\Controllers\Admin\CommentController");
    Route::resource("ads", "App\Http\Controllers\Admin\AdController");
    Route::resource("pages", "App\Http\Controllers\Admin\PageController");
    Route::resource("users", "App\Http\Controllers\Admin\UserController");
    Route::resource("permissions", "App\Http\Controllers\Admin\PermissionController");
    Route::resource("roles", "App\Http\Controllers\Admin\RoleController");
    Route::resource("contacts", "App\Http\Controllers\Admin\ContactController");
    Route::resource("sliders", "App\Http\Controllers\Admin\SliderController");
    Route::resource("vantages", "App\Http\Controllers\Admin\VantageController");
    Route::resource("videos", "App\Http\Controllers\Admin\VideoController");
    Route::resource("bloggers", "App\Http\Controllers\Admin\BloggerController");

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

Auth::routes();

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/journals', [PageController::class, 'journals'])->name('journals');
Route::get('/organizations', [PageController::class, 'organizations'])->name('organizations');
Route::get('/business', [PageController::class, 'business'])->name('business');
Route::get('/community', [PageController::class, 'community'])->name('community');
Route::get('/travel', [PageController::class, 'travel'])->name('travel');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/searchad', [PageController::class, 'searchad'])->name('searchad');

//news
Route::get('/news/trends/{category?}', [NewsController::class, 'trends'])->name('news_trends');
Route::get('/news/category_posts/{category?}', [NewsController::class, 'category_posts'])->name('category_posts');
Route::get('/news/pasts/{category?}', [NewsController::class, 'pasts'])->name('news_pasts');
Route::get('/news/editors/{category?}', [NewsController::class, 'editors'])->name('news_editors');

//journals
Route::get('/journal/travels/{category?}', [JournalController::class, 'travels'])->name('journal_travels');
Route::get('/journal/populars/{category?}', [JournalController::class, 'populars'])->name('journal_populars');
Route::get('/journal/posts/{category?}', [JournalController::class, 'posts'])->name('journal_posts');

//organizations
Route::get('/organization/organizations/{category?}', [\App\Http\Controllers\OrganizationController::class, 'organizations'])->name('org_organizations');
Route::get('/organization/korean/{category?}', [\App\Http\Controllers\OrganizationController::class, 'korean'])->name('org_korean');
Route::get('/organization/education/{category?}', [\App\Http\Controllers\OrganizationController::class, 'education'])->name('org_educations');
Route::get('/organization/media/{category?}', [\App\Http\Controllers\OrganizationController::class, 'media'])->name('org_media');

//business
Route::get('/business/rests/{category?}', [BusinessController::class, 'rests'])->name('business_rests');
Route::get('/business/hotels/{category?}', [BusinessController::class, 'hotels'])->name('business_hotels');
Route::get('/business/sports/{category?}', [BusinessController::class, 'sports'])->name('business_sports');
Route::get('/business/medical/{category?}', [BusinessController::class, 'medical'])->name('business_medical');
Route::get('/business/tourism/{category?}', [BusinessController::class, 'tourism'])->name('business_tourism');
Route::get('/business/sports/{category?}', [BusinessController::class, 'sports'])->name('business_sports');
Route::get('/business/edus/{category?}', [BusinessController::class, 'edus'])->name('business_edus');
Route::get('/business/laws/{category?}', [BusinessController::class, 'laws'])->name('business_laws');
Route::get('/business/karaoke/{category?}', [BusinessController::class, 'karaoke'])->name('business_karaoke');
Route::get('/business/beauty/{category?}', [BusinessController::class, 'beauty'])->name('business_beauty');
Route::get('/business/academies/{category?}', [BusinessController::class, 'academies'])->name('business_academies');

//travel
Route::get('/travel/russia/{category?}', [TravelController::class, 'russia'])->name('travel_russia');
Route::get('/travel/kyrgyzstan/{category?}', [TravelController::class, 'kg'])->name('travel_kg');
Route::get('/travel/kazakhstan/{category?}', [TravelController::class, 'kz'])->name('travel_kz');
Route::get('/travel/uzbekistan/{category?}', [TravelController::class, 'uz'])->name('travel_uz');

Route::post('/storeComment', [PageController::class, 'storeComment'])->name('storeComment');
Route::get('/createAd', [PageController::class, 'createAd'])->name('createAd');
Route::post('/storeAd', [PageController::class, 'storeAd'])->name('storeAd');

//Route::get('/tag/{post}', [PageController::class, 'tag'])->name('tag');
//Route::get('/tag/{tag}/{post}', [PageController::class, 'post'])->name('post');

Route::get('/category/{category}', [PageController::class, 'category'])->name('category');
Route::get('/taglist/{tag}', [PageController::class, 'taglist'])->name('taglist');
Route::get('/post/{post}', [PageController::class, 'post'])->name('post');
Route::get('/{ad}', [PageController::class, 'ad'])->name('ad');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');






