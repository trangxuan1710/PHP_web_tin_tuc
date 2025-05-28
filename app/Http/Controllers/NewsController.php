<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\News;

class NewsController extends Controller
{
    public function show($id)
    {
        $news = News::with([
            'user',
            'label',
            'comments.client',
            'comments.replies.client'
        ])->findOrFail($id);
        ;

        $news->increment('views');
        return view('news.show', compact('news'));

    }



    public function savedNews()
    {
        $savedNews = [];

        if (Auth::check()) {
            $user = Auth::user();

            // Giả sử bạn có quan hệ savedNews trong model User
            if (method_exists($user, 'savedNews')) {
                $savedNews = $user->savedNews()->latest()->get();
            }
        } else {
            // Lấy từ session nếu chưa đăng nhập
            $savedIds = Session::get('saved_news', []);
            $savedNews = News::whereIn('id', $savedIds)->latest()->get();
        }

        return view('news.saved', compact('savedNews'));
    }
    public function save($id)
    {
        $user = auth()->user();

        if ($user) {
            $user->savedNews()->syncWithoutDetaching([$id]); // giả sử dùng many-to-many
            return redirect()->route('news.show', $id)->with('success', 'Đã lưu bài viết!');
        }

        return redirect()->route('news.show', $id)->with('error', 'Bạn cần đăng nhập để lưu bài viết.');
    }


}
