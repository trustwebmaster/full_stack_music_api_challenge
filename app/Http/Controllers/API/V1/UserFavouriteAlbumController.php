<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavouriteAlbumRequest;
use App\Http\Resources\UserFavouriteAlbumResource;
use App\Http\Services\ResponseService;
use App\Http\Services\UserFavouriteAlbumService;
use App\Models\UserFavouriteAlbum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class UserFavouriteAlbumController extends Controller
{

    public UserFavouriteAlbumService $userFavouriteAlbumService;
    public ResponseService $responseService;

    public function __construct(UserFavouriteAlbumService $userFavouriteAlbumService , ResponseService $responseService){

        $this->userFavouriteAlbumService = $userFavouriteAlbumService;
        $this->responseService = $responseService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $albumData =  $this->userFavouriteAlbumService->getAlbums($request);

        return $this->responseService->successResponse($albumData);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFavouriteAlbumRequest $request): JsonResponse
    {
        try {

            $createdAlbum = $this->userFavouriteAlbumService->createAlbum($request->validated());

            return $this->responseService->successResponse($createdAlbum);

        }catch (ValidationException $validationException) {

            $errors = $validationException->errors();

            return $this->responseService->errorResponse('Validation failed', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $errors);
        }

        catch(\Exception $exception){
            Log::error('An Error while creating album , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while adding album to favourites');


        }

    }

    /**
     * Display the specified resource.
     */
    public function show(UserFavouriteAlbum $userFavouriteAlbum): JsonResponse
    {
        $userFavouriteAlbumCollection = UserFavouriteAlbumResource::collection($userFavouriteAlbum);

        return $this->responseService->successResponse($userFavouriteAlbumCollection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFavouriteAlbumRequest $userFavouriteAlbumRequest, UserFavouriteAlbum $userFavouriteAlbum): JsonResponse
    {
        try{
        $updatedAlbum = $this->userFavouriteAlbumService->updateAlbum($userFavouriteAlbum , $userFavouriteAlbumRequest->validated());

        return $this->responseService->successResponse($updatedAlbum);

    }catch (ValidationException $validationException) {

            $errors = $validationException->errors();

            return $this->responseService->errorResponse('Validation failed', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $errors);
        }

    catch(\Exception $exception){
        Log::error('An Error while updating album , Error: ' . $exception->getMessage());

        return $this->responseService->errorResponse('An error occurred while updating album');

       }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFavouriteAlbum $userFavouriteAlbum): JsonResponse
    {
        try{

            $userFavouriteAlbum->delete();

            return $this->responseService->successResponse('Album successfully removed from favorites');

        } catch(\Exception $exception){
            Log::error('An Error while removing album , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while removing album');

        }
    }
}
