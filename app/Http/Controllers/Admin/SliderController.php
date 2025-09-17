<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
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
        return view('auth.sliders.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            $path = $request->file('image')->store('sliders');
            $params['image'] = $path;
        }
        Slider::create($params);
        session()->flash('success', 'Slider created');

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Slider $slider)
    {
        return view('auth.sliders.form', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($slider->image);
            $params['image'] = $request->file('image')->store('sliders');
        }
        $slider->update($params);
        session()->flash('success', 'Slider updated');

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        Storage::delete($slider->image);
        session()->flash('success', 'Slider deleted');

        return redirect()->route('dashboard');
    }

}
