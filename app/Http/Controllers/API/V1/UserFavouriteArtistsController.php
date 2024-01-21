<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavouriteArtistsRequest;
use App\Http\Resources\UserFavouriteArtistsResource;
use App\Http\Services\ResponseService;
use App\Http\Services\UserFavouriteArtistsService;
use App\Models\UserFavouriteArtist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserFavouriteArtistsController extends Controller
{

    public UserFavouriteArtistsService $userFavouriteArtistService;
    public ResponseService $responseService;

    public function __construct(UserFavouriteArtistsService $userFavouriteArtistService , ResponseService $responseService){

        $this->userFavouriteArtistService = $userFavouriteArtistService;
        $this->responseService = $responseService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $artistData =  $this->userFavouriteArtistService->getArtists($request);

        return $this->responseService->successResponse($artistData);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFavouriteArtistsRequest $request): JsonResponse
    {
        try {

            $createdArtist = $this->userFavouriteArtistService->createArtist($request->validated());

            return $this->responseService->successResponse($createdArtist);

        }catch (ValidationException $validationException) {

            $errors = $validationException->errors();

            return $this->responseService->errorResponse('Validation failed', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $errors);
        }

        catch(\Exception $exception){
            Log::error('An Error while adding artist to favourites , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while adding artist to favourites');


        }

    }

    /**
     * Display the specified resource.
     */
    public function show(UserFavouriteArtist $userFavouriteArtist): JsonResponse
    {
        $userFavouriteArtistCollection = UserFavouriteArtistsResource::collection($userFavouriteArtist);

        return $this->responseService->successResponse($userFavouriteArtistCollection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFavouriteArtistsRequest $userFavouriteArtistsRequest, UserFavouriteArtist $userFavouriteArtist): JsonResponse
    {
        try{
            $updatedArtist = $this->userFavouriteArtistService->updateArtist($userFavouriteArtist , $userFavouriteArtistsRequest->validated());

            return $this->responseService->successResponse($updatedArtist);

        }catch (ValidationException $validationException) {

            $errors = $validationException->errors();

            return $this->responseService->errorResponse('Validation failed', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $errors);
        }

        catch(\Exception $exception){
            Log::error('An Error while updating artist , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while updating artist');

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFavouriteArtist $userFavouriteArtist): JsonResponse
    {
        try{

            $userFavouriteArtist->delete();

            return $this->responseService->successResponse('Artist successfully removed from favorites');

        } catch(\Exception $exception){
            Log::error('An Error while removing artist , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while removing artist');

        }
    }
}
