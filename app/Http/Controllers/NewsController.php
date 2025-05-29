<?php

namespace App\Http\Controllers;

use App\Models\Label;
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

class   NewsController extends Controller
{
    public function search(Request $request)
    {
        $query = News::query()->with('label'); // Eager load 'label' relationship
        // 1. Keyword Search in Title
        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where('title', 'LIKE', "%{$keyword}%");
        }
        log:info($request);
        // 2. Filter by Label (Category)
        if ($request->filled('category_filter') && $request->input('category_filter') !== 'all') {
            $labelType = $request->input('category_filter');
            $query->join('labels', 'news.labelId', '=', 'labels.id')
                ->where('labels.type', $labelType);
        }
        // 3. Filter by Time
        if ($request->filled('time_filter') && $request->input('time_filter') !== 'all') {
            $timeFilter = $request->input('time_filter');
            switch ($timeFilter) {
                case 'today':
                    $query->whereDate('date', today()); // 'date' là cột chứa ngày tháng trong model News
                    break;
                case 'this_week':
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
            }
        }

        // 4. Ordering
        $query->orderBy('date', 'desc');

        // 5. Pagination
        $results = $query->paginate(5)->withQueryString();

        // 6. Fetch Labels for the filter dropdown
        $labels = Label::all();
        log::info($labels);
        $hotNews = News::with('label')
        ->where('status', 'publish')
        ->where('isHot', '1')
        ->orderBy('date', 'desc')
        ->take(5)
        ->get();
        // 7. Return the view
        return view('news.search', compact('labels', 'results','hotNews'));
    }
    public function show($id)
    {
        $news = News::with([
            'manager',
            'label',
            'comments'
        ])->find($id);
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
            $user->savedNews()->syncWithoutDetaching([$id]);
            return redirect()->route('news.show', $id)->with('success', 'Đã lưu bài viết!');
        }
        return redirect()->route('news.show', $id)->with('error', 'Bạn cần đăng nhập để lưu bài viết.');
    }
    public function showManageNews(Request $request)
    {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $keyword = $request->input('keyword');
        $labelId = $request->input('label_id'); // Lấy label_id từ request

        // Lấy tất cả các nhãn để truyền vào dropdown
        $labels = Label::all();

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

    public function formCreateNews(Request $request) {
        $managerId = $request->session()->get('logged_in_manager_id');
        $manager  = Managers::find($managerId);
        if($manager == null){
            return redirect()->route('managerLogin');
        }
        $labels = Label::orderBy('type')->get();
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

        $labelType = Label::find($request->label_id)->type;
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
        $news = News::with('manager', 'label')->findOrFail($id);

        $labels = Label::orderBy('type')->get(); // Lấy danh sách labels để hiển thị dropdown

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

        $labelType = Label::find($request->label_id)->type;

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

}
