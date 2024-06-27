<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->withErrors('You need to log in to post a comment.');
        }
        
        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->auction_id = $request->auction_id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();

        return redirect()->back()->with('success', 'Comment posted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->hasRole('admin')) {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        } else {
            return redirect()->back()->withErrors('You do not have permission to delete this comment.');
        }
    }
}
