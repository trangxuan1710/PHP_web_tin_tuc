<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News; // Đảm bảo bạn đã tạo model News
use Illuminate\Support\Facades\Auth; // Import Auth facade

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // Chỉ cho phép người dùng đã đăng nhập truy cập
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lấy dữ liệu tin tức từ database để hiển thị trên trang chủ
        // Dựa trên cấu trúc DB của bạn, bạn có thể lấy tin tức từ bảng 'news'
        // Ví dụ: Lấy 10 bài viết mới nhất, sắp xếp theo ngày
        $news = News::orderBy('date', 'desc')->take(10)->get();

        return view('home', compact('news')); // Truyền dữ liệu tin tức sang view home.blade.php
    }
}
