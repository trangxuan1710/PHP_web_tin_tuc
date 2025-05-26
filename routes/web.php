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

Route::get('profile/{id}/change-password', function ($id) {
    return view('change-password', ['id' => $id]);
})->name('change-password');
Route::put('profile/{id}/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');

/*
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile');

});

*/