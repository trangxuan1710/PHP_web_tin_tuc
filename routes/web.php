<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NewsController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Client;
use App\Http\Controllers\ReportController;
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
Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');

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
