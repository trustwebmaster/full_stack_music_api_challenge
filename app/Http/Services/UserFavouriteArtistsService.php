<?php

namespace App\Http\Services;

use App\Http\Resources\UserFavouriteArtistsResource;
use App\Models\UserFavouriteArtist;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class UserFavouriteArtistsService{


    protected ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }


    public function getArtists($request): AnonymousResourceCollectionAlias
    {
        $user = $request->user();

        return UserFavouriteArtistsResource::collection($user->favouriteArtists()->get());

    }

    public function createArtist($request): AnonymousResourceCollectionAlias
    {

        $newArtist = UserFavouriteArtist::create($request);

        return UserFavouriteArtistsResource::collection($newArtist);

    }

    public function updateArtist($userFavouriteArtist , $request): AnonymousResourceCollectionAlias
    {

        $updatedArtist = $userFavouriteArtist->update($request);

        return UserFavouriteArtistsResource::collection($updatedArtist);

    }

}
