<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Http\Requests\AdUpdateRequest;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-ad|edit-ad|delete-ad', ['only' => ['index','show']]);
        $this->middleware('permission:create-ad', ['only' => ['create','store']]);
        $this->middleware('permission:edit-ad', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-ad', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ads = Ad::paginate(20);
        return view('auth.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.ads.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdRequest $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        Ad::create($params);

        session()->flash('success', 'Ad ' . $request->title . ' created');
        return redirect()->route('ads.index');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Ad $ad)
    {
        return view('auth.ads.form', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdUpdateRequest $request, Ad $ad)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        $ad->update($params);
        session()->flash('success', 'Ad ' . $request->title . ' updated');

        return redirect()->route('ads.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        session()->flash('success', 'Ad ' . $ad->title . ' deleted');

        return redirect()->route('ads.index');
    }

}
