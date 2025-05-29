<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Notifications;
use App\Models\NearestNews;
use App\Models\SaveNews;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mockery\Matcher\Not;

use Illuminate\Support\Carbon;

class ProfileController extends Controller
{

    protected function showProfile()
    {

        /** @var \App\Models\Clients $client */
        $client = Auth::user();

        if (!$client) {
            abort(404);
            // redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem thông tin cá nhân.');
        }

        // Lấy danh sách thông báo (ví dụ: relation receivedNotifications)
        $notifications = $client->receivedNotifications()
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'replierId' => $notification->replierId,
                    'replierName' => $notification->replierName, // Sử dụng accessor để lấy tên người gửi
                    'newsURL' => $notification->newsURL,
                    'content' => $notification->content,
                    'date' => $notification->created_at->format('Y-m-d H:i'),
                    'isRead' => $notification->isRead,
                ];
            });


        $saveNewsCollection = $client->saveNews()
            ->orderByDesc('created_at')
            ->get();

        $saveNews = $saveNewsCollection->map(function ($newsItem) {
            $carbonDate = Carbon::parse($newsItem->created_at);

            $newsItem->created_at = $carbonDate->format('Y-m-d H:i');

            return $newsItem;
        })->toArray();

        $nearestNewsCollection = $client->nearestNews()
            ->latest()
            ->get();
        $nearestNews = $nearestNewsCollection->map(function ($newsItem) {
            $carbonDate = Carbon::parse($newsItem->updated_at);

            $newsItem->updated_at = $carbonDate->format('Y-m-d H:i');

            return $newsItem;
        })->toArray();

        return view('user-profile', [
            'client' => $client,
            'notifications' => $notifications,
            'saveNews' => $saveNews,
            'nearestNews' => $nearestNews,
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Clients $client */
        $client = Auth::user();

        if (!$client) {
            return response()->json(['message' => 'Người dùng chưa đăng nhập.'], 401);
        }

        try {
            // Laravel sẽ tự động nhận dữ liệu từ JSON body của request
            $validatedData = $request->validate([
                'fullName' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('clients')->ignore($client->id),
                ],
                'bio' => 'nullable|string|max:500',
                'avatarUrl' => 'nullable|string',
                // Thêm các trường khác nếu có
            ]);

            $client->fill($validatedData);
            $client->save();

            return response()->json([
                'message' => 'Thông tin cá nhân của bạn đã được cập nhật thành công!',
                'client' => $client->fresh(), // Tùy chọn: trả về đối tượng client đã cập nhật
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel sẽ tự động trả về lỗi JSON 422 với chi tiết lỗi
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Xử lý các lỗi server không mong muốn
            return response()->json([
                'message' => 'Đã xảy ra lỗi server: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getUserName(int $id)
    {
        $client = Clients::select('fullName')->find($id);
        if (!$client) {
            return response()->json(['message' => 'Người dùng không tồn tại.'], 404);
        }
        return response()->json(['fullName' => $client->fullName], 200);
    }

    public function readNotifications(Request $request)
    {
        /** @var \App\Models\Clients $client */
        $client = Auth::user();

        if (!$client) {
            abort(404, 'Người dùng không tồn tại.');
        }

        // Cập nhật trạng thái đã đọc cho tất cả thông báo của người dùng
        $notificationId = $request->input('id');

        try {

            if ($notificationId === null) {
                // Trường hợp 1: notificationId là null, đánh dấu TẤT CẢ thông báo chưa đọc
                Notifications::where('clientId', $client->id)
                    ->where('isRead', false)
                    ->update(['isRead' => true]);

                return response()->json(['message' => 'Tất cả thông báo đã được đánh dấu là đã đọc.'], 200);
            } else {
                // Trường hợp 2: notificationId có giá trị, đánh dấu MỘT thông báo cụ thể
                $notification = Notifications::find($notificationId);

                if (!$notification) {
                    return response()->json(['message' => 'Thông báo không tồn tại.'], 404);
                }

                // Chỉ cập nhật nếu chưa đọc để tránh truy vấn không cần thiết
                if (!$notification->isRead) {
                    $notification->isRead = true;
                    $notification->save();
                }

                return response()->json(['message' => 'Thông báo đã được đánh dấu là đã đọc.'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi khi cập nhật thông báo.'], 500);
        }
    }

    public function deleteNotifications(Request $request)
    {
        /** @var \App\Models\Clients $client */
        $client = Auth::user();

        $notificationId = $request->input('notificationId');

        if ($notificationId === null) {
            Notifications::where('clientId', $client->id)
                ->where('isRead', true)
                ->delete();
            return response()->json(['message' => 'Tất cả thông báo đã đọc đã được xóa thành công.'], 200);
        }

        $notification = Notifications::find($notificationId);

        if (!$notification) {
            return response()->json(['message' => 'Thông báo không tồn tại.'], 404);
        }

        $notification->delete();

        return response()->json(['message' => 'Thông báo đã được xóa thành công.'], 200);
    }

    public function deleteSavedNews(Request $request)
    {
        // 1. Xác thực dữ liệu đầu vào
        $request->validate([
            'id' => 'required|integer|exists:news,id',
        ]);

        if (!Auth::check()) {
            // Trả về lỗi nếu người dùng chưa đăng nhập
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'], 401);
            }
            return back()->with('error', 'Bạn cần đăng nhập để bỏ lưu bài viết.');
        }

        $clientId = Auth::user()->id; // Lấy ID của người dùng đang đăng nhập
        $newsId = $request->input('id');

        try {
            // Tìm và xóa bản ghi trong bảng save_news
            $deleted = SaveNews::where('client_id', $clientId)
                ->where('news_id', $newsId)
                ->delete();

            if (!$deleted) {
                // Trả về phản hồi thành công
                return response()->json(['message' => 'Đã bỏ lưu bài viết thành công!']);
            } else {
                // Trả về lỗi nếu không tìm thấy bản ghi để xóa
                return response()->json(['message' => 'Không tìm thấy bài viết đã lưu để bỏ lưu.'], 404);
            }
        } catch (\Exception $e) {
            // Ghi log lỗi để debug
            Log::error("Lỗi khi bỏ lưu tin tức: " . $e->getMessage(), [
                'client_id' => $clientId,
                'news_id' => $newsId,
                'exception' => $e
            ]);

            // Trả về phản hồi lỗi
            return response()->json(['message' => 'Đã xảy ra lỗi khi bỏ lưu bài viết.'], 500);
        }
    }

    public function deleteNearestNews(Request $request)
    {
        // 1. Xác thực dữ liệu đầu vào
        $request->validate([
            'id' => 'required|integer|exists:news,id',
        ]);

        if (!Auth::check()) {
            // Trả về lỗi nếu người dùng chưa đăng nhập
            return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'], 401);
        }

        $clientId = Auth::user()->id; // Lấy ID của người dùng đang đăng nhập
        $newsId = $request->input('id');

        try {
            // Tìm và xóa bản ghi trong bảng save_news
            $deleted = NearestNews::where('client_id', $clientId)
                ->where('news_id', $newsId)
                ->delete();

            if (!$deleted) {
                // Trả về phản hồi thành công
                return response()->json(['message' => 'Đã bỏ lưu bài viết thành công!']);
            } else {
                // Trả về lỗi nếu không tìm thấy bản ghi để xóa
                return response()->json(['message' => 'Không tìm thấy bài viết đã lưu để bỏ lưu.'], 404);
            }
        } catch (\Exception $e) {
            // Ghi log lỗi để debug
            Log::error("Lỗi khi bỏ lưu tin tức: " . $e->getMessage(), [
                'client_id' => $clientId,
                'news_id' => $newsId,
                'exception' => $e
            ]);

            // Trả về phản hồi lỗi
            return response()->json(['message' => 'Đã xảy ra lỗi khi bỏ lưu bài viết.'], 500);
        }
    }


    public function changePassword(Request $request)
    {
        /** @var \App\Models\Clients $client */
        $client = Auth::user();

        if (!$client) {
            return response()->json(['message' => 'Người dùng không tồn tại.'], 404);
        }

        $validatedData = $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validatedData['currentPassword'], $client->password)) {
            return response()->json(['message' => 'Mật khẩu hiện tại không đúng.'], 403);
        }

        $client->password = Hash::make($validatedData['newPassword']);
        $client->save();

        return response()->json(['message' => 'Mật khẩu đã được cập nhật thành công.'], 200);
    }
}
