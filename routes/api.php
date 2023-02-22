<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerLyrics;
use App\Http\Controllers\Api\ProfileController;

>>>>>>> Stashed changes

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
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

    Route::post('logout', 'logout');
});
Route::resource('/lyrics', ControllerLyrics::class);

Route::group(['middleware' => ['token-verify']], function () {

    Route::post('/profile/change_password', [ProfileController::class, 'change_password']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('profil', [AuthController::class, 'profil']);
});

//fouad
Route::apiResource('albums', AlbumController::class);
//fouad



