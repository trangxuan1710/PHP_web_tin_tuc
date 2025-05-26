<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function showManageNews()
    {

        $news = News::with('manager')
        ->orderBy('date', 'desc') // Sắp xếp theo cột 'date' giảm dần
        ->get();

        // Truyền biến $news sang view
        return view('managers.manageNews', compact('news'));
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
}
