<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
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
