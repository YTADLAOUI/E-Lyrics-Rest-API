<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerLyrics;

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
    Route::post('logout', 'logout');

});
Route::resource('/lyrics',ControllerLyrics::class);

Route::group(['middleware' => ['token-verify']], function() {

    Route::post('logout',[AuthController::class,'logout']);
    Route::post('profil',[AuthController::class,'profil']);

});

//fouad
Route::apiResource('albums', AlbumController::class);
//fouad


