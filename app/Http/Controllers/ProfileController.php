<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Notifications;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Matcher\Not;

class ProfileController extends Controller
{

    protected function showProfile(int $id)
    {

        /** @var \App\Models\Clients $client */
        $client = Clients::find($id);

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

        return view('user-profile', [
            'client' => $client,
            'notifications' => $notifications,
        ]);
    }

    public function updateProfile(int $id, Request $request)
    {
        /** @var \App\Models\Client $client */
        $client = Clients::find($id);

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
                'avatarUrl' => 'nullable|string|max:255|url',
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

    public function readNotifications(int $id, Request $request)
    {
        $client = Clients::find($id);

        if (!$client) {
            abort(404, 'Người dùng không tồn tại.');
        }

        // Cập nhật trạng thái đã đọc cho tất cả thông báo của người dùng
        $notificationId = $request->input('id');

        try {

            if ($notificationId === null) {
                // Trường hợp 1: notificationId là null, đánh dấu TẤT CẢ thông báo chưa đọc
                Notifications::where('clientId', $id)
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

    public function deleteNotifications(int $id, Request $request)
    {
        $notificationId = $request->input('notificationId');

        if ($notificationId === null) {
            Notifications::where('clientId', $id)
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

    function updatePassword(int $id, Request $request) {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);
        $clientId = $request->session()->get('logged_in_client_id');
        $client = Clients::find($clientId);
        log::info($client);
        log::info($request->current_password);
        if (password_verify(Request('current_password'), $manager->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('Mật khẩu hiện tại không chính xác.'),
            ]);
        }
        $manager->update([
            'password' => Hash::make($request->password),
        ]);


}
