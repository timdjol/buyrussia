<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\PageController::class, 'dashboard'])->name('dashboard');
    Route::post('posts/uploadMedia', [\App\Http\Controllers\Admin\PageController::class, 'uploadMedia'])->name('uploadMedia');
    Route::get('/logout', [\App\Http\Controllers\Admin\PageController::class, 'logout'])->name('get-logout');

    Route::resource("categories", "App\Http\Controllers\Admin\CategoryController");
    Route::resource("tags", "App\Http\Controllers\Admin\TagController");
    Route::resource("posts", "App\Http\Controllers\Admin\PostController");
    Route::resource("items", "App\Http\Controllers\Admin\ItemController");
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

Route::post('/storeComment', [PageController::class, 'storeComment'])->name('storeComment');
Route::get('/createAd', [PageController::class, 'createAd'])->name('createAd');
Route::post('/storeAd', [PageController::class, 'storeAd'])->name('storeAd');

Route::get('/tag/{post}', [PageController::class, 'tag'])->name('tag');
Route::get('/tag/{tag}/{post}', [PageController::class, 'post'])->name('post');
Route::get('/category/{category}', [PageController::class, 'category'])->name('category');
Route::get('/category/{category}/{post}', [PageController::class, 'post'])->name('post');
Route::get('/{ad}', [PageController::class, 'ad'])->name('ad');


