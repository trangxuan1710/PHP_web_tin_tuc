<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Clients; // Import Clients model if not already (for clarity, though not directly used here)
use App\Models\Managers;
use App\Models\News;    // Import News model if not already (for clarity, though not directly used here)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function __construct()
    {
        // Constructor logic if any
    }

    public function index(Request $request)
    {
        $id = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($id);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $query = Comment::with(['client', 'news']);

        if ($request->has('search_id') && !empty($request->search_id)) {
            $query->where('id', $request->search_id);
        }

        if ($request->has('search_sender') && !empty($request->search_sender)) {
            $searchTerm = $request->search_sender;
            $query->whereHas('client', function ($q) use ($searchTerm) {
                $q->where('fullName', 'like', '%' . $searchTerm . '%');
            });
        }

        $comments = $query->latest()->paginate(10);
        return view('managers.manageComment', compact('manager','comments'));
    }

    public function delete( $commentId, Request $request)
    {
        $id = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($id);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        try {
            $comment = Comment::query()
                ->with(['client', 'news'])
                ->find($commentId);;
            $client =  $comment->client;
            $client->isMute = $client->isMute - 1 ;
            $client->save();
            $comment->delete();
            return redirect()->route('manageCommentsIndex')->with('success', 'Bình luận đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('manageCommentsIndex')->with('error', 'Không thể xóa bình luận: ' . $e->getMessage());
        }
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
    public function index2($newsId) // news details
    {
        $news = News::findOrFail($newsId); // thêm dòng này nếu bạn chưa có

        $comments = Comment::whereNull('commentId')
            ->whereHas('news', fn($q) => $q->where('newsId', $newsId))
            ->with(['client', 'replies.client'])
            ->orderByDesc('date')
            ->paginate(10);

        return view('comments.index', compact('comments', 'newsId','news'));
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'commentId' => 'nullable|exists:comments,id',
            'newsId' => 'required'
        ]);

        // Xác định người dùng (nếu chưa đăng nhập thì lấy ID 1 là ẩn danh)
        $clientId = auth()->check() ? auth()->id() : 1;

        $content = $request->content;
        $news = $request->newsId;
        $commentId = null;

        if ($request->filled('commentId')) {
            $parent = Comment::find($request->commentId);

            if ($parent) {
                // Nếu parent là phản hồi (cấp con), thì commentId phải là cha gốc (1 cấp thôi)
                $commentId = $parent->commentId ?? $parent->id;

                // Gắn @username nếu có
                if ($parent->client) {
                    $tag = '@' . $parent->client->name;
                    if (!str_starts_with($content, $tag)) {
                        $content = "$tag $content";
                    }
                }
            }
        }

        $comment = Comment::create([
            'clientId' => $clientId,
            'content' => $content,
            'date' => now(),
            'like_count' => 0,
            'commentId' => $commentId,
            'newsId' => $news,
        ]);

        $comment->news()->attach($id);

        return redirect()->route('news.show', $id)->with('scroll_to_comment', true);
    }
}
