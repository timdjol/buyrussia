<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
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
        return view('auth.videos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        Video::create($params);
        session()->flash('success', 'Video created');

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Video $video)
    {
        return view('auth.videos.form', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $params = $request->all();
        $video->update($params);
        session()->flash('success', 'Video updated');

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();
        session()->flash('success', 'Video deleted');

        return redirect()->route('dashboard');
    }

}
