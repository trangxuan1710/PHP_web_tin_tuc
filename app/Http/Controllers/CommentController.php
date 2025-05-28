<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Clients; // Import Clients model if not already (for clarity, though not directly used here)
use App\Models\Managers;
use App\Models\News;    // Import News model if not already (for clarity, though not directly used here)
use Illuminate\Http\Request;

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
        $query = Comments::with(['client', 'news']);

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

    public function delete(Request $request, $commentId) // Use Route Model Binding directly
    {
        $id = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($id);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        try {

            $comment = Comments::with(['client', 'news'])::find($commentId);
            $client = $comment->isMute -1;
            $client->save();
            $comment->delete();
            return redirect()->route('manageCommentsIndex')->with('success', 'Bình luận đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('manageCommentsIndex')->with('error', 'Không thể xóa bình luận: ' . $e->getMessage());
        }
    }
}
