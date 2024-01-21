<?php

namespace App\Http\Services;

use App\Models\UserFavouriteAlbum;

class AlbumService {

    public  static function getAlbumByUserId(string $userId){

        return UserFavouriteAlbum::where('user_id', $userId)->first();

    }


    public  static function getUserAlbumByNameAndArtist($userId , $validatedAlbum){

        return UserFavouriteAlbum::where('name', $validatedAlbum['name'])
                                   ->where('artist_name' , $validatedAlbum['artist_name'])
                                   ->where('user_id' , $userId)
                                    ->first();

    }


}
