<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-comment|edit-comment|delete-comment', ['only' => ['index','show']]);
        $this->middleware('permission:create-comment', ['only' => ['create','store']]);
        $this->middleware('permission:edit-comment', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-comment', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(30);
        return view('auth.comments.index', compact('comments'));
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Comment $comment)
    {
        return view('auth.comments.form', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $params = $request->all();
        $comment->update($params);
        session()->flash('success', 'Comment updated');

        return redirect()->route('comments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        session()->flash('success', 'Comment deleted');
        return redirect()->route('comments.index');
    }
    

}



