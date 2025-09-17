<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-tag|edit-tag|delete-tag', ['only' => ['index','show']]);
        $this->middleware('permission:create-tag', ['only' => ['create','store']]);
        $this->middleware('permission:edit-tag', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-tag', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tags = Tag::paginate(10);
        return view('auth.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.tags.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        Tag::create($params);

        session()->flash('success', 'Tag ' . $request->title . ' created');
        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Tag $tag)
    {
        return view('auth.tags.form', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        $tag->update($params);
        session()->flash('success', 'Tag ' . $request->title . ' updated');

        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Post::where('tag_id', $tag->id)->update(['tag_id' => null]);
        $tag->delete();
        session()->flash('success', 'Tag ' . $tag->title . ' deleted');

        return redirect()->route('tags.index');
    }

}
