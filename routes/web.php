<?php

use App\Http\Controllers\ManagerController;
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

Route::get('/manager/login', [ManagerController::class, 'showLoginForm'])->name('login');
Route::get('/manager/manageNews', [ManagerController::class, 'showManageNews'])->name('manageNews');

Route::post('/manager/login', [ManagerController::class, 'handleLogin']);
