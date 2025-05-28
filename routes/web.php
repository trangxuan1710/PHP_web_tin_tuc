<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Client;

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

Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');

Route::put('/profile/{id}/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

/*
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');

});

*/