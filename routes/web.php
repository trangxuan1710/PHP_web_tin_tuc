<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NewsController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Client;
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

Route::get('/', function () {
    return view('home');
});

<<<<<<< HEAD
Route::get('/manager/login', [ManagerController::class, 'showLoginForm'])->name('managerLogin');
Route::post('/manager/login', [ManagerController::class, 'handleLogin']);
Route::get('/manager/logout', [ManagerController::class, 'handleLogout'])->name('managerLogout');
Route::get('/manager/changePassword', [ManagerController::class,'changePasswordForm'])->name('managerChangePassword');
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
Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');

Route::put('/profile/{id}/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

/*
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');

});

*/
=======
Route::get('/signup', function () {
    return view('auth.user-signup');
});

Route::get('/login', function () {
    return view('auth.user-login');
});

Route::post('/signup', [AuthenticationController::class, 'register'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');

/*
Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');
Route::put('/profile/{id}/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/user/{tab?}', [ProfileController::class, 'showProfile'])
        ->where('tab', 'profile|saveNews|nearestNews|accountSettings')
        ->name('profile.tab');
    Route::put('/user/change-password', [ProfileController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::put('/notifications/read', [ProfileController::class, 'readNotifications'])->name('notifications.read');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/notifications/delete', [ProfileController::class, 'deleteNotifications'])->name('notifications.delete');
});
>>>>>>> c1eca48 (add login signup, update profile)
