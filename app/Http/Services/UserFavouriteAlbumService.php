<?php

namespace App\Http\Services;


use App\Http\Resources\UserFavouriteAlbumResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;


class  UserFavouriteAlbumService{

    public function getAlbums($user): AnonymousResourceCollectionAlias
    {
        return UserFavouriteAlbumResource::collection($user->favouriteAlbums()->get());
    }

    public function createAlbum($user , $validatedData): UserFavouriteAlbumResource
    {
        $newAlbum = $user->favouriteAlbums()->create($validatedData);

        return new UserFavouriteAlbumResource($newAlbum);

    }

    public function updateAlbum($userFavouriteAlbum , $request): UserFavouriteAlbumResource
    {
        $userFavouriteAlbum->update($request);

        return new UserFavouriteAlbumResource($userFavouriteAlbum);

    }

}
