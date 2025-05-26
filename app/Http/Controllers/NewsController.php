<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function showManageNews(Request $request) // Truyền Request vào phương thức
    {
        $query = News::with('manager');


        $keyword = $request->input('keyword'); // hoặc $request->query('keyword')

        if ($keyword && $keyword!='') {
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%'); // Tìm kiếm trong tiêu đề
            });
        }

        // Sắp xếp theo cột 'date' giảm dần
        $news = $query->orderBy('date', 'desc')->get();

        // Truyền biến $news và $keyword sang view
        return view('managers.manageNews', compact('news', 'keyword'));
    }
    //
    public function formCreateNews() {
        $labels = Labels::orderBy('type')->get();
        return view('managers.createNews', compact('labels'));
    }
    public function store(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'label_id' => 'required|exists:labels,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // max 2MB
            'isHot' => 'required|in:0,1|boolean',
        ]);

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
            'isHot' => (bool)$request->isHot,
            'managerId' => 1,
            'labelId' => $request->label_id,
        ]);
        log::info($news);
        return redirect()->route('manageNews')->with('success', 'Tin tức đã được lưu thành công!');
    }
    public function edit($id)
    {
        // Tìm bài viết theo ID, nếu không tìm thấy sẽ tự động trả về 404
        $news = News::with('manager', 'label')->findOrFail($id); // Eager load manager và label

        $labels = Labels::orderBy('type')->get(); // Lấy danh sách labels để hiển thị dropdown

        // Truyền cả $news (bài viết cần chỉnh sửa) và $labels sang view
        return view('managers.createNews', compact('news', 'labels'));
    }
    public function update(Request $request, $id)
    {
        // Tìm bài viết cần cập nhật
        $news = News::findOrFail($id);

        // Validate dữ liệu đầu vào (tương tự store nhưng có thể có quy tắc khác cho update)
        $request->validate([
            'title' => 'required|string|max:255',
            'label_id' => 'required|exists:labels,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // null nếu không upload mới
            'isHot' => 'required|in:0,1|boolean',
        ]);

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
            // 'managerId' và 'labelId' có thể không cần cập nhật nếu chúng không đổi
            'labelId' => $request->label_id, // Cập nhật labelId từ form
        ]);

        return redirect()->route('manageNews')->with('success', 'Tin tức đã được cập nhật thành công!');
    }
    public function destroy($id, Request $request)
    {
        $news = News::find($id);

        if (!$news) {
            // Nếu không tìm thấy tin tức, trả về lỗi 404
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Tin tức không tồn tại.'], 404);
            }
            return redirect()->back()->with('error', 'Tin tức không tồn tại.');
        }

        try {
            // Lấy đường dẫn thumbnail trước khi xóa bản ghi (nếu có)
            $thumbnailPath = $news->thumbNailUrl;

            // Xóa bản ghi tin tức khỏi database
            $news->delete();

            // Xóa file thumbnail khỏi storage nếu nó tồn tại
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            // Trả về phản hồi thành công
            if ($request->wantsJson()) {
                // Nếu là AJAX request, trả về JSON response
                return response()->json(['message' => 'Tin tức đã được xóa thành công!']);
            }
            // Nếu không phải AJAX, chuyển hướng về trang trước đó hoặc trang danh sách
            return redirect()->route('news.index')->with('success', 'Tin tức đã được xóa thành công!');

        } catch (\Exception $e) {
            // Xử lý lỗi trong quá trình xóa
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Lỗi khi xóa tin tức: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Lỗi khi xóa tin tức: ' . $e->getMessage());
        }
    }
}
