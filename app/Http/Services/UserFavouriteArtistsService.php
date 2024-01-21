<?php

namespace App\Http\Services;

use App\Http\Resources\UserFavouriteArtistsResource;
use App\Models\UserFavouriteArtist;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;
use Illuminate\Support\Facades\Auth;

class UserFavouriteArtistsService{


    protected ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }


    public function getArtists($user): AnonymousResourceCollectionAlias
    {

        return UserFavouriteArtistsResource::collection($user->favouriteArtists()->get());

    }

    public function createArtist($user, $validatedArtist): UserFavouriteArtistsResource
    {

        $newArtist = $user->favouriteArtists()->create($validatedArtist);

        return new UserFavouriteArtistsResource($newArtist);

    }

    public function updateArtist($userFavouriteArtist , $request): UserFavouriteArtistsResource
    {

        $userFavouriteArtist->update($request);

        return new UserFavouriteArtistsResource($userFavouriteArtist);

    }

}
