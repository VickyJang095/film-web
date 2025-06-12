<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'content' => 'required|min:3|max:1000'
        ]);

        $movie->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Bình luận đã được thêm thành công!');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() === $comment->user_id || Auth::user()->role === 'admin') {
            $comment->delete();
            return back()->with('success', 'Bình luận đã được xóa!');
        }

        return back()->with('error', 'Bạn không có quyền xóa bình luận này!');
    }
} 