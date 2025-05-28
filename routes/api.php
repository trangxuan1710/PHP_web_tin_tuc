<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('/notifications/read/{id}', [ProfileController::class, 'readNotifications'])->name('api.notifications.read');
Route::put('/profile/update/{id}', [ProfileController::class, 'updateProfile'])->name('api.profile.update');

Route::delete('/notifications/delete/{id}', [ProfileController::class, 'deleteNotifications'])->name('api.notifications.delete');

