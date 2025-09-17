<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VantageController extends Controller
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
        return view('auth.vantages.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            $path = $request->file('image')->store('vantages');
            $params['image'] = $path;
        }
        vantage::create($params);
        session()->flash('success', 'Vantage created');

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Vantage $vantage)
    {
        return view('auth.vantages.form', compact('vantage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vantage $vantage)
    {
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($vantage->image);
            $params['image'] = $request->file('image')->store('vantages');
        }
        $vantage->update($params);
        session()->flash('success', 'Vantage updated');

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vantage $vantage)
    {
        $vantage->delete();
        Storage::delete($vantage->image);
        session()->flash('success', 'Vantage deleted');

        return redirect()->route('dashboard');
    }

}
