<?php

use App\Http\Controllers\API\V1\AlbumController;
use App\Http\Controllers\API\V1\ArtistsController;
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


Route::prefix('auth')->group( function () {
    Route::get('/google/redirect', GoogleRedirectController::class);
    Route::get('/google/callback',  GoogleCallbackController::class);
});

Route::post('artists' , [ArtistsController::class , 'searchArtists']);
Route::post('artist/view' , [ArtistsController::class , 'viewArtist']);

Route::post('albums' , [AlbumController::class , 'searchAlbums']);
Route::post('album/view' , [AlbumController::class , 'viewAlbum']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/favourite/albums', UserFavouriteAlbumController::class);
    Route::apiResource('/favourite/artists', UserFavouriteArtistsController::class);
});

