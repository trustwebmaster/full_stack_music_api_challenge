<?php

use App\Http\Controllers\API\V1\AlbumController;
use App\Http\Controllers\API\V1\ArtistsController;
use App\Http\Controllers\API\V1\Auth\UserAuthController;
use App\Http\Controllers\API\V1\SocialAuth\GoogleCallbackController;
use App\Http\Controllers\API\V1\SocialAuth\GoogleRedirectController;
use App\Http\Controllers\API\V1\UserFavouriteAlbumController;
use App\Http\Controllers\API\V1\UserFavouriteArtistsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [UserAuthController::class, 'register'])->name('register');
Route::post('login', [UserAuthController::class, 'login'])->name('login');


Route::prefix('auth')->group( function () {
    Route::get('/google/redirect', GoogleRedirectController::class)->name('google.redirect');
    Route::get('/google/callback',  GoogleCallbackController::class);
});

Route::post('artists' , [ArtistsController::class , 'searchArtists'])->name('artists');
Route::post('artist/view' , [ArtistsController::class , 'viewArtist'])->name('artist.view');

Route::post('albums' , [AlbumController::class , 'searchAlbums'])->name('albums');
Route::post('album/view' , [AlbumController::class , 'viewAlbum'])->name('album.view');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/favourite/albums', UserFavouriteAlbumController::class);
    Route::apiResource('/favourite/artists', UserFavouriteArtistsController::class);
});
