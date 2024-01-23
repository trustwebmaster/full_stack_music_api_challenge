<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\LastFmApiService;
use App\Http\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{

    const API_TYPE_ALBUM = 'album';
    protected LastFmApiService $lastFmApiService;
    protected ResponseService $responseService;

    public function __construct(LastFmApiService $lastFmApiService , ResponseService $responseService)
    {
        $this->lastFmApiService = $lastFmApiService;
        $this->responseService = $responseService;
    }

    public function searchAlbums(Request $request)
    {
        try {

            $searchQuery = $request->input('query', '');

            $apiMethod = 'album.search';

            $data = $this->lastFmApiService->getLastFmApiClient($apiMethod , $searchQuery , self::API_TYPE_ALBUM);

            $albums = $data['results']['albummatches']['album'] ?? [];


            return $this->responseService->successResponse($albums ?: 'No albums were found');


        }catch (\Exception $exception){

            Log::error('An Error occurred , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while searching for albums');

        }

    }


    public function viewAlbum(Request $request){
        try {

            $searchQuery = $request->input('album', '');
            $artist = $request->input('artist', '');
            $apiMethod = 'album.getinfo';


            $data = $this->lastFmApiService->getLastFmApiAlbum($apiMethod , $searchQuery , self::API_TYPE_ALBUM , $artist);

            $albumInfo = $data['album'] ?? [];

            return $this->responseService->successResponse($albumInfo ?: 'No artists were found');


        }catch (\Exception $exception){

            Log::error('An Error occurred , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while retrieving data for artist');

        }


    }

}
