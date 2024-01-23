<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFavouriteAlbumRequest;
use App\Http\Resources\UserFavouriteAlbumResource;
use App\Http\Services\AlbumService;
use App\Http\Services\ResponseService;
use App\Http\Services\UserFavouriteAlbumService;
use App\Models\UserFavouriteAlbum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class UserFavouriteAlbumController extends Controller
{

    public UserFavouriteAlbumService $userFavouriteAlbumService;
    public ResponseService $responseService;
    public AlbumService $albumService;

    public function __construct(UserFavouriteAlbumService $userFavouriteAlbumService, ResponseService $responseService , AlbumService $albumService)
    {
        $this->userFavouriteAlbumService = $userFavouriteAlbumService;
        $this->albumService = $albumService;
        $this->responseService = $responseService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $albumData =  $this->userFavouriteAlbumService->getAlbums($request->user());
        return $this->responseService->successResponse($albumData);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFavouriteAlbumRequest $request): JsonResponse
    {
        try {
            $validatedAlbum = $request->validated();
            $validatedAlbum['album_slug'] =  Str::slug('zatec music api '.$request->input('name'));

            $existingAlbum = $this->albumService->getUserAlbumByNameAndArtist($request->user()->id ,$validatedAlbum);


            $createdAlbum = $this->userFavouriteAlbumService->createAlbum($request->user() , $validatedAlbum);

            return $this->responseService->successResponse($createdAlbum , ResponseAlias::HTTP_CREATED);

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
    public function show($userFavouriteAlbumId): JsonResponse
    {
        $userFavouriteAlbum = UserFavouriteAlbum::findOrFail($userFavouriteAlbumId);

        $userFavouriteAlbumCollection = UserFavouriteAlbumResource::make($userFavouriteAlbum);

        return $this->responseService->successResponse($userFavouriteAlbumCollection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFavouriteAlbumRequest $userFavouriteAlbumRequest,$userFavouriteAlbumId ): JsonResponse
    {
        try{

            $userFavouriteAlbum = UserFavouriteAlbum::findOrFail($userFavouriteAlbumId);

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
    public function destroy($userFavouriteAlbumId): JsonResponse
    {
        try{
            $userFavouriteAlbum = UserFavouriteAlbum::findOrFail($userFavouriteAlbumId);
            $userFavouriteAlbum->delete();

            return $this->responseService->successResponse('Album successfully removed from favorites');

        } catch(\Exception $exception){
            Log::error('An Error while removing album , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while removing album');

        }
    }
}
