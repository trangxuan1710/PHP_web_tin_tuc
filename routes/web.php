<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NewsController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\HomeController;
use App\Models\News; // Đảm bảo đã import Model News
use App\Models\Label; // Đảm bảo đã import Model Label nếu bạn sử dụng nó

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    return view('test');
});
Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');

// Route cho trang chủ mặc định (hoặc khi chưa đăng nhập)
/*Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home'); // Nếu đã đăng nhập, chuyển hướng đến trang home đã đăng nhập
    }

    // Lấy dữ liệu tin tức từ database để hiển thị trên trang welcome
    // Đảm bảo bạn có dữ liệu trong bảng 'news' để tránh lỗi
    $featuredNews = null;
    $recentNews = collect(); // Khởi tạo collection rỗng
    $businessNews = collect(); // Khởi tạo collection rỗng

    try {
        $featuredNews = News::orderBy('date', 'desc')->first(); // Lấy 1 bài nổi bật nhất
        // Nếu có bài nổi bật, lấy các bài gần đây khác
        $recentNews = News::orderBy('date', 'desc')->skip(1)->take(3)->get(); // Lấy 3 bài gần đây (trừ bài nổi bật)

        // Lấy 3 bài kinh doanh
        // Đảm bảo rằng model Label và mối quan hệ đã được định nghĩa đúng
        $businessLabel = Label::where('type', 'Kinh doanh')->first();
        if ($businessLabel) {
            $businessNews = News::where('labelId', $businessLabel->id)
                ->orderBy('date', 'desc')
                ->take(3)
                ->get();
        }
    } catch (\Exception $e) {
        // Xử lý lỗi nếu không thể kết nối database hoặc không tìm thấy bảng/dữ liệu
        // Bạn có thể log lỗi này hoặc hiển thị thông báo thân thiện hơn cho người dùng
        Log::error("Lỗi khi lấy dữ liệu tin tức cho trang welcome: " . $e->getMessage());
        // Các biến sẽ vẫn là null/collection rỗng, view sẽ xử lý hiển thị "Không có dữ liệu"
    }


    return view('welcome', compact('featuredNews', 'recentNews', 'businessNews')); // Truyền dữ liệu vào view
})->name('welcome');
*/
// Các routes xác thực của Laravel (đăng nhập, đăng ký, đăng xuất)
Auth::routes();

// Route cho trang chủ khi đã đăng nhập
Route::get('/', [NewsController::class, 'showListNews'])->name('home');

Route::get('/{tab?}', [NewsController::class, 'showListNews'])
        ->where('tab', 'tin-nong|doi-song|the-thao|khoa-hoc-cong-nghe|suc-khoe|giai-tri|kinh-doanh')
        ->name('tab');

// Route tin tức
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::post('/save-news', [NewsController::class, 'saveNews'])->name('news.save');

// Route bình luận

Route::post('/report/send', [ReportController::class, 'sendReport'])->name('reports.comments.store');

Route::middleware('auth')->group(function () {
    Route::get('/news/{newsId}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/news/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/{id}/dislike', [CommentController::class, 'dislike'])->name('comments.dislike');
    Route::post('/comments/{id}/report', [CommentController::class, 'report'])->name('comments.report');
});

Route::get('/manager/login', [ManagerController::class, 'showLoginForm'])->name('managerLogin');
Route::post('/manager/login', [ManagerController::class, 'handleLogin']);
Route::get('/manager/logout', [ManagerController::class, 'handleLogout'])->name('managerLogout');
Route::get('/manager/changePassword', [ManagerController::class, 'changePasswordForm'])->name('managerChangePassword');
Route::put('/manager/changePassword', [ManagerController::class, 'handleChangePassword']);
Route::get('/manager/manageNews', [NewsController::class, 'showManageNews'])->name('manageNews');
Route::get('/manager/manageNews/addNews', [NewsController::class, 'formCreateNews'])->name('addNews');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/manager/manageNews/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');

Route::get('/manager/manageComments', [CommentController::class, 'index'])->name('manageCommentsIndex');
Route::delete('comments/{commentId}', [CommentController::class, 'delete'])->name('manageCommentsDelete');



Route::get('/manager/manageReports', [ReportController::class, 'index'])->name('managerManageReports');
Route::post('/manager/processReport/{id}', [ReportController::class, 'processReport'])->name('processReport');

// Đăng nhập, đăng ký
Route::get('/signup', function () {
    return view('auth.user-signup');
})->name('signup');
Route::get('/login', function () {
    return view('auth.user-login');
})->name('login');
Route::post('/signup', [AuthenticationController::class, 'register'])->name('signup');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');

/*
Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');
Route::put('/profile/{id}/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
*/

use Illuminate\Http\Request;
use Illuminate\Support\Str; // For Str::limit

Route::get('/search', [NewsController::class, 'search'])->name('news.search');
Route::middleware(['auth'])->group(function () {
    Route::get('/user', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/user/{tab?}', [ProfileController::class, 'showProfile'])
        ->where('tab', 'profile|saveNews|nearestNews|accountSettings')
        ->name('profile.tab');
    Route::put('/user/change-password', [ProfileController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::delete('/saveNews/delete', [ProfileController::class, 'deleteSaveNews'])->name('saveNews.delete');
    Route::delete('/nearestNews/delete', [ProfileController::class, 'deleteNearestNews'])->name('nearestNews.delete');

    Route::put('/notifications/read', [ProfileController::class, 'readNotifications'])->name('notifications.read');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/notifications/delete', [ProfileController::class, 'deleteNotifications'])->name('notifications.delete');
});
