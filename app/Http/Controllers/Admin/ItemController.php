<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-post|edit-post|delete-post', ['only' => ['index','show']]);
        $this->middleware('permission:create-post', ['only' => ['create','store']]);
        $this->middleware('permission:edit-post', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-post', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ids = [3,52,53,54,55,51,5,57,58,59,56];
        $count = Post::whereNotIn('category_id', $ids)->get();
        $posts = Post::whereNotIn('category_id', $ids)->latest()->paginate(20);
        return view('auth.items.index', compact('posts', 'count'));
    }

    public function create()
    {
        $roots = Category::with('children.children.children')
            ->roots()->orderBy('title')->get();

        $selected = collect(old('category_id', []))
            ->map(fn($v)=>(int)$v)->all();

        return view('auth.items.form', compact('roots','selected'));
    }

    public function edit(Post $post)
    {
        $post->load('categories:id'); // чтобы pluck не делал лишних запросов

        $roots = Category::with('children.children.children')
            ->roots()->orderBy('title')->get();

        // дефолт — то, что уже сохранено в БД
        $pre = $post->categories->pluck('id')->all();

        // сначала old() (если была ошибка валидации), иначе $pre
        $selected = collect(old('category_id', $pre))
            ->map(fn($v)=>(int)$v)->all();

        return view('auth.items.form', compact('post','roots','selected'));
    }

    public function store(PostRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['code'] = Str::slug($data['title']);
            $data['user_id'] = Auth::id();  // не из формы, а с сервера

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $images[] = $file->store('posts', 'public');
                }
            }
            $data['images'] = $images;

            // Если колонка category_id в таблице больше не нужна как CSV — лучше убрать следующие 2 строки.
            $data['category_id'] = $request->filled('category_id') ? implode(', ', $request->category_id) : null;
            $data['tag_id']      = $request->filled('tag_id') ? implode(', ', $request->tag_id) : null;

            $post = Post::create($data);

            // pivot
            $post->categories()->sync($request->input('category_id', []));

            session()->flash('success', 'Post ' . $request->title . ' created');
            return redirect()->route('items.index');
        });
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        return DB::transaction(function () use ($request, $post) {
            $data = $request->validated();
            $data['code'] = Str::slug($data['title']);
            $data['user_id'] = Auth::id();  // тоже ставим на сервере

            if ($request->hasFile('image')) {
                if ($post->image) Storage::disk('public')->delete($post->image);
                $data['image'] = $request->file('image')->store('posts', 'public');
            }

            $images = $post->images ?? [];

            foreach ($request->input('remove_images', []) as $path) {
                Storage::disk('public')->delete($path);
                $images = array_values(array_filter($images, fn ($p) => $p !== $path));
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $images[] = $file->store('posts', 'public');
                }
            }

            $data['images'] = $images;

            // см. комментарий выше — CSV лучше не хранить, если есть pivot
            $data['category_id'] = $request->filled('category_id') ? implode(', ', $request->category_id) : null;
            $data['tag_id']      = $request->filled('tag_id') ? implode(', ', $request->tag_id) : null;

            $post->update($data);

            $post->categories()->sync($request->input('category_id', []));

            session()->flash('success', 'Post ' . $request->title . ' updated');
            return redirect()->route('items.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // удалим файлы до удаления записи
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        foreach (($post->images ?? []) as $p) {
            Storage::disk('public')->delete($p);
        }

        $post->categories()->detach();
        //$post->tags()->detach();
        $post->delete();

        session()->flash('success', 'Post ' . $post->title . ' deleted');
        return redirect()->route('items.index');
    }

}
