<?php

namespace App\Http\Services;


use App\Http\Resources\UserFavouriteAlbumResource;
use App\Http\Services\ResponseService;
use App\Models\UserFavouriteAlbum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class  UserFavouriteAlbumService{

    protected ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }


    public function getAlbums($request): AnonymousResourceCollectionAlias
    {
         $user = $request->user();

        return UserFavouriteAlbumResource::collection($user->favouriteAlbums()->get());

    }

    public function createAlbum($request): AnonymousResourceCollectionAlias
    {

        $newAlbum = UserFavouriteAlbum::create($request);

        return UserFavouriteAlbumResource::collection($newAlbum);

    }

    public function updateAlbum($userFavouriteAlbum , $request): AnonymousResourceCollectionAlias
    {

        $updatedAlbum = $userFavouriteAlbum->update($request);

        return UserFavouriteAlbumResource::collection($updatedAlbum);

    }

}
