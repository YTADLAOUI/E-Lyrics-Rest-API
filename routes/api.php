<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerLyrics;
use App\Http\Controllers\Api\ProfileController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//PUBLIC
Route::apiResource('/artist', ArtistController::class);

//PRIVATE
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');

});
Route::resource('/lyrics', ControllerLyrics::class);

Route::group(['middleware' => ['token-verify']], function () {
    Route::post('/profile/change_password', [ProfileController::class, 'change_password']);
    Route::post('/profile/{id}/profile_edit', [ProfileController::class, 'profile_edit']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('profil', [AuthController::class, 'profil']);
    Route::post('logout', [AuthController::class,'logout']);


});


//fouad
Route::apiResource('albums', AlbumController::class);
//fouad



// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login']);
// Route::post('/profile/change-password', ProfileController::class, 'change_password');
