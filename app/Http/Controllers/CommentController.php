<?php

namespace App\Http\Controllers;


use App\Models\Comments;

use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {

        $query = Comments::with(['client', 'news']);

        // Implement search functionality (optional)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('content', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('post', function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%');
                });
        }

        // Order by latest comments first
        $comments = $query->latest()->paginate(10); // 10 comments per page

        return view('managers.manageComment', compact('comments'));
    }

    public function delete($id,Comments $comment)
    {
        try {
            $comment = $comment->find($id);
            $comment->delete();
            return redirect()->route('manageCommentsIndex')->with('success', 'Bình luận đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('manageCommentsIndex')->with('error', 'Không thể xóa bình luận: ' . $e->getMessage());
        }
    }

}
