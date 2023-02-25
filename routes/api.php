<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\LyricController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SongController;



//PUBLIC
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});


//PRIVATE (Admin)
Route::group(['middleware' => ['token-verify','admin-verify']], function () {
    Route::apiResource('/artists', ArtistController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/albums', AlbumController::class);
    Route::resource('/songs', SongController::class);
    Route::resource('/lyrics', LyricController::class);
});
// (User)
Route::group(['middleware' => ['token-verify']], function () {

    Route::apiResource('/artists', ArtistController::class)->only('index','show');
    Route::apiResource('/albums', AlbumController::class)->only('index','show');
    Route::resource('/songs', SongController::class)->only('index','show');

    Route::resource('/lyrics', LyricController::class);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/profile/{id}/profile_edit', [ProfileController::class, 'profile_edit']);
    Route::post('/profile/change_password', [ProfileController::class, 'change_password']);
    Route::post('profil', [AuthController::class, 'profil']);

});


