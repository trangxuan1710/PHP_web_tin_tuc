<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;

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

//Route::middleware('auth')->group(function () {
Route::get('/news/{newsId}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
Route::post('/comments/{id}/dislike', [CommentController::class, 'dislike'])->name('comments.dislike');
Route::post('/comments/{id}/report', [CommentController::class, 'report'])->name('comments.report');

//});
