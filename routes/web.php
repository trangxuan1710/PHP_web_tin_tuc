<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/manager/manageNews', [NewsController::class, 'showManageNews'])->name('manageNews');
Route::get('/manager/manageNews/addNews', [NewsController::class, 'formCreateNews'])->name('addNews');

Route::post('/news', [NewsController::class, 'store'])->name('news.store');


