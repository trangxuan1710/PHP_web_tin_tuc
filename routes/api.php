<?php

use App\Http\Controllers\AuthenticationController;
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

Route::middleware('auth')->group(function () {
    Route::put('/notifications/read', [ProfileController::class, 'readNotifications'])->name('api.notifications.read');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('api.profile.update');

    Route::delete('/notifications/delete', [ProfileController::class, 'deleteNotifications'])->name('api.notifications.delete');
});
