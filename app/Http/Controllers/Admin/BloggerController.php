<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BloggerController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//        $this->middleware('permission:create-post|edit-post|delete-post', ['only' => ['index','show']]);
//        $this->middleware('permission:create-post', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-post', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete-post', ['only' => ['destroy']]);
//    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.bloggers.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            $path = $request->file('image')->store('bloggers');
            $params['image'] = $path;
        }
        Blogger::create($params);
        session()->flash('success', 'Blogger created');

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Blogger $blogger)
    {
        return view('auth.bloggers.form', compact('blogger'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blogger $blogger)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($blogger->image);
            $params['image'] = $request->file('image')->store('bloggers');
        }
        $blogger->update($params);
        session()->flash('success', 'Blogger updated');

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogger $blogger)
    {
        $blogger->delete();
        Storage::delete($blogger->image);
        session()->flash('success', 'Blogger deleted');

        return redirect()->route('dashboard');
    }

}
