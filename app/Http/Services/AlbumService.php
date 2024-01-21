<?php

namespace App\Http\Services;

use App\Models\UserFavouriteAlbum;

class AlbumService {

    public  static function getAlbumByUserId(string $userId){

        return UserFavouriteAlbum::where('user_id', $userId)->first();

    }
}
