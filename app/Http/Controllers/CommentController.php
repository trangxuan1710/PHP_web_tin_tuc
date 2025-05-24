<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
//    public function index($newsId)
//    {
//        // Lấy bình luận cha và phản hồi kèm user
//        $comments = Comment::whereNull('commentId')
//            ->whereHas('news', fn($q) => $q->where('newsId', $newsId))
//            ->with([
//                'client',
//                'replies.client'
//            ])
//            ->orderByDesc('date')
//            ->get();
//
//        return view('comments.index', compact('comments', 'newsId'));
//    }
//
//    public function store(Request $request)
//    {
//        $request->validate([
//            'content' => 'required|string',
//            'newsId' => 'required|exists:news,id',
//            'commentId' => 'nullable|exists:comments,id',
//        ]);
//
//        $content = $request->input('content');
//        $commentId = $request->input('commentId');
//
//        // Nếu là phản hồi của phản hồi => thêm @tag
//        if ($commentId) {
//            $parent = Comment::find($commentId);
//            if ($parent && $parent->commentId !== null) {
//                $tag = '@' . $parent->client->name;
//                $content = "$tag " . $content;
//            }
//        }
//
//        $comment = Comment::create([
//            'clientId' => Auth::id(), // hoặc $request->user()->id nếu dùng auth
//            'content' => $content,
//            'date' => Carbon::now(),
//            'like_count' => 0,
//            'commentId' => $commentId,
//        ]);
//
//        // Gắn vào bài viết
//        $comment->news()->attach($request->input('newsId'));
//
//        return redirect()->back();
//    }
    public function index($newsId)
    {
        $comments = Comment::whereNull('commentId')
            ->whereHas('news', fn($q) => $q->where('newsId', $newsId))
            ->with(['client', 'replies.client'])
            ->orderByDesc('date')
            ->get();

        return view('comments.index', compact('comments', 'newsId'));
    }

    public function store(Request $request)
    {
        $comment = Comment::create([
            'clientId' => 1, // test, bạn thay auth()->id() nếu có đăng nhập
            'content' => $request->content,
            'date' => now(),
            'like_count' => 0,
            'commentId' => $request->commentId,
        ]);
        $comment->news()->attach($request->newsId);

        return back();
    }

    public function like($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->increment('like_count');
        return response()->json(['like_count' => $comment->like_count]);
    }

    public function dislike($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->increment('dislike_count');
        return response()->json(['dislike_count' => $comment->dislike_count]);
    }

    public function report($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->increment('report_count');
        return response()->json(['report_count' => $comment->report_count]);
    }

}
