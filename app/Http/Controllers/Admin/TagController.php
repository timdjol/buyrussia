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
    public function index()
    {
        $tags = Tag::paginate(20);
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
        return redirect()->route('taglists.index');
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

        return redirect()->route('taglists.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Post::where('region_id', $tag->id)->update(['region_id' => null]);
        Post::where('company_id', $tag->id)->update(['company_id' => null]);
        $tag->delete();
        session()->flash('success', 'Tag ' . $tag->title . ' deleted');

        return redirect()->route('taglists.index');
    }

}
