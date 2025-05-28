<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Models\Managers;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Comment; // Để lấy số lượng comment
use Carbon\Carbon; // Import Carbon

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
    public function showManageNews(Request $request) // Truyền Request vào phương thức
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $keyword = $request->input('keyword');
        $labelId = $request->input('label_id'); // Lấy label_id từ request

        // Lấy tất cả các nhãn để truyền vào dropdown
        $labels = Labels::all();

        $news = News::with(['manager', 'label']) // Eager load mối quan hệ manager và label
        ->when($keyword, function ($query, $keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
        })
            ->when($labelId, function ($query, $labelId) {
                $query->where('labelId', $labelId); // Lọc theo labelId
            })
            ->orderBy('date', 'desc') // Hoặc thứ tự bạn muốn
            ->get();

        return view('managers.manageNews', compact('manager','news', 'keyword', 'labelId','labels'));
    }
    //
    public function formCreateNews(Request $request) {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $labels = Labels::orderBy('type')->get();
        return view('managers.createNews', compact('manager','labels'));
    }
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'label_id' => 'required|exists:labels,id',
            'content' => 'required|string',
            'action_type' => 'required|in:draft,publish',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // max 2MB
            'isHot' => 'required|in:0,1|boolean',
        ]);

        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        log::info($request);
        $thumbNailUrl = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/news_thumbnails', $fileName);
            $thumbNailUrl = '/storage/news_thumbnails/' . $fileName;
        }

        $labelType = Labels::find($request->label_id)->type;
        // 3. Tạo bài viết tin tức mới trong cơ sở dữ liệu
        $news = News::create([
            'title' => $request->title,
            'tag' => $labelType,
            'content' => $request->input('content'),
            'thumbNailUrl' => $thumbNailUrl,
            'status' => $request->input('action_type'),
            'isHot' => (bool)$request->isHot,
            'managerId' => $managerId,
            'labelId' => $request->label_id,
        ]);
        log::info($news);
        return redirect()->route('manageNews')->with('success', 'Tin tức đã được lưu thành công!');
    }
    public function edit(Request $request, $id)
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        // Tìm bài viết theo ID, nếu không tìm thấy sẽ tự động trả về 404
        $news = News::with('manager', 'label')->findOrFail($id); // Eager load manager và label

        $labels = Labels::orderBy('type')->get(); // Lấy danh sách labels để hiển thị dropdown

        // Truyền cả $news (bài viết cần chỉnh sửa) và $labels sang view
        return view('managers.createNews', compact('manager','news', 'labels'));
    }
    public function update(Request $request, $id)
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        // Tìm bài viết cần cập nhật
        $news = News::findOrFail($id);
        // Validate dữ liệu đầu vào (tương tự store nhưng có thể có quy tắc khác cho update)
        $request->validate([
            'title' => 'required|string|max:255',
            'label_id' => 'required|exists:labels,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // null nếu không upload mới
            'isHot' => 'required|in:0,1|boolean',
            'action_type' => 'required|in:draft,publish',
        ]);
        log::info(@$news->thumbnail);
        $thumbNailUrl = $news->thumbNailUrl; // Giữ lại ảnh cũ nếu không upload ảnh mới

        // Xử lý upload ảnh thumbnail MỚI (nếu có)
        if ($request->hasFile('thumbnail')) {
            // Xóa ảnh cũ nếu có và ảnh cũ không phải là mặc định
            if ($news->thumbNailUrl && file_exists(public_path(str_replace('/storage/', 'storage/app/public/', $news->thumbNailUrl)))) {
                unlink(public_path(str_replace('/storage/', 'storage/app/public/', $news->thumbNailUrl)));
            }
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/news_thumbnails', $fileName);
            $thumbNailUrl = '/storage/news_thumbnails/' . $fileName;
        }

        $labelType = Labels::find($request->label_id)->type;

        // Cập nhật bài viết
        $news->update([
            'title' => $request->title,
            'tag' => $labelType,
            'content' => $request->input('content'),
            'thumbNailUrl' => $thumbNailUrl, // Cập nhật đường dẫn ảnh
            'isHot' => (bool)$request->isHot,
            'status' => $request->input('action_type'),
            // 'managerId' và 'labelId' có thể không cần cập nhật nếu chúng không đổi
            'labelId' => $request->label_id,
        ]);

        return redirect()->route('manageNews')->with('success', 'Tin tức đã được cập nhật thành công!');
    }
    public function destroy($id, Request $request)
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $news = News::find($id);

        if (!$news) {
            // Nếu không tìm thấy tin tức, trả về lỗi 404
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Tin tức không tồn tại.'], 404);
            }
            return redirect()->back()->with('error', 'Tin tức không tồn tại.');
        }

        try {
            $thumbnailPath = $news->thumbNailUrl;
            $news->delete();
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Tin tức đã được xóa thành công!']);
            }
            return redirect()->route('news.index')->with('success', 'Tin tức đã được xóa thành công!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Lỗi khi xóa tin tức: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Lỗi khi xóa tin tức: ' . $e->getMessage());
        }
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $time = $request->input('time', 'all');
        $tag = $request->input('tag', 'all'); // Đổi từ 'category' sang 'tag'
        $status = $request->input('status', 'all'); // Thêm bộ lọc 'status'
        $sortBy = $request->input('sort', 'latest');

        $news = News::query();

        // Lọc theo từ khóa (title hoặc content/description)
        if (!empty($query)) {
            $news->where(function($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('content', 'LIKE', '%' . $query . '%') // Thay thế description bằng content
                    ->orWhere('tag', 'LIKE', '%' . $query . '%'); // Có thể tìm trong tag nữa
            });
        }

        // Lọc theo tag
        if ($tag !== 'all') {
            $news->where('tag', 'LIKE', '%' . $tag . '%'); // Tìm kiếm tag chứa từ khóa
        }

        // Lọc theo status
        if ($status !== 'all') {
            $news->where('status', $status);
        }

        // Lọc theo thời gian (dựa trên trường 'date' của bạn)
        switch ($time) {
            case 'today':
                $news->whereDate('date', Carbon::today());
                break;
            case 'week':
                $news->whereBetween('date', [Carbon::now()->startOfWeek(Carbon::MONDAY), Carbon::now()->endOfWeek(Carbon::SUNDAY)]);
                break;
            case 'month':
                $news->whereMonth('date', Carbon::now()->month)
                    ->whereYear('date', Carbon::now()->year);
                break;
            case 'year':
                $news->whereYear('date', Carbon::now()->year);
                break;
        }

        // Sắp xếp
        if ($sortBy === 'latest') {
            $news->orderBy('date', 'desc'); // Sắp xếp theo trường 'date'
        } elseif ($sortBy === 'relevance') {
            // Sắp xếp theo độ liên quan
            // Để sắp xếp theo comment_count, bạn cần join bảng comments hoặc tính toán trước
            // Ví dụ tạm thời: sắp xếp theo isHot và date
            $news->orderBy('isHot', 'desc')->orderBy('date', 'desc');

            // Để sắp xếp theo số lượng comment THỰC TẾ:
            // $news->withCount('comments') // Eager load và đếm số lượng comment
            //      ->orderBy('comments_count', 'desc')
            //      ->orderBy('date', 'desc');
        }

        // Lấy các giá trị duy nhất cho dropdown
        // Tags có thể phức tạp hơn nếu bạn lưu nhiều tag trong 1 chuỗi.
        // Bạn có thể cần một bảng tags riêng nếu muốn quản lý tag chặt chẽ.
        // Tạm thời, ta lấy tất cả các tag riêng biệt từ cột 'tag' và tách ra (có thể có trùng lặp nếu 1 bài có nhiều tag)
        $allTagsFromDb = News::distinct()->pluck('tag')->filter()->toArray();
        $uniqueTags = [];
        foreach ($allTagsFromDb as $tagString) {
            $tagsArray = explode(',', $tagString);
            foreach ($tagsArray as $tagItem) {
                $uniqueTags[] = trim($tagItem);
            }
        }
        $uniqueTags = array_values(array_unique(array_filter($uniqueTags))); // Lọc giá trị rỗng và loại bỏ trùng lặp

        $statuses = News::distinct()->pluck('status')->filter()->values()->toArray(); // Lấy các trạng thái duy nhất

        $results = $news->paginate(10); // Phân trang 10 bài viết mỗi trang

        return view('news.search', compact('results', 'query', 'time', 'tag', 'status', 'sortBy', 'uniqueTags', 'statuses'));
    }
}
