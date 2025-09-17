<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-page|edit-page|delete-page', ['only' => ['index','show']]);
        $this->middleware('permission:create-page', ['only' => ['create','store']]);
        $this->middleware('permission:edit-page', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-page', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::first();
        return view('auth.contacts.index', compact('contact'));
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Contact $contact)
    {
        return view('auth.contacts.form', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $params = $request->all();
        if ($request->has('ban')) {
            $path = $request->file('ban')->store('contacts');
            $params['ban'] = $path;
        } else {
            unset($params['ban']);
        }

        if ($request->has('ban2')) {
            $path = $request->file('ban2')->store('contacts');
            $params['ban2'] = $path;
        } else {
            unset($params['ban2']);
        }

        if ($request->has('ban3')) {
            $path = $request->file('ban3')->store('contacts');
            $params['ban3'] = $path;
        } else {
            unset($params['ban3']);
        }

        if ($request->has('ban4')) {
            $path = $request->file('ban4')->store('contacts');
            $params['ban4'] = $path;
        } else {
            unset($params['ban4']);
        }

        $contact->update($params);
        session()->flash('success', 'Contact ' . $request->title . ' updated');

        return redirect()->route('contacts.index');
    }

}



