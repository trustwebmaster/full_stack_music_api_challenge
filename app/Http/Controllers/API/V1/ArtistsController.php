<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\LastFmApiService;
use App\Http\Services\ResponseService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArtistsController extends Controller
{

    const API_TYPE_ARTIST = 'artist';

    protected LastFmApiService $lastFmApiService;
    protected ResponseService $responseService;

    public function __construct(LastFmApiService $lastFmApiService , ResponseService $responseService)
    {
        $this->lastFmApiService = $lastFmApiService;
        $this->responseService = $responseService;
    }

    public function searchArtists(Request $request)
    {
        try {

            $searchQuery = $request->input('query', '');
            $apiMethod = 'artist.search';

            $data = $this->lastFmApiService->getLastFmApiClient($apiMethod , $searchQuery , self::API_TYPE_ARTIST);

            $artists = $data['results']['artistmatches']['artist'] ?? [];

            return $artists;

            return $this->responseService->successResponse($artists ?: 'No artists were found');


        }catch (\Exception $exception){

            Log::error('An Error occurred , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while searching for artists');

        }

    }


    public function viewArtist(Request $request){
        try {

            $searchQuery = $request->input('name', '');
            $apiMethod = 'artist.getinfo';

            $data = $this->lastFmApiService->getLastFmApiClient($apiMethod , $searchQuery , self::API_TYPE_ARTIST);

            $artist = $data['artist'] ?? [];

            return $this->responseService->successResponse($artist ?: 'No artists were found');


        }catch (\Exception $exception){

            Log::error('An Error occurred , Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('An error occurred while retrieving data for artist');

        }


    }


}
