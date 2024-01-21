<?php

namespace App\Http\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class LastFmApiService{

    protected mixed $apiKey;
    protected mixed $baseUrl;
    private Client $client;

    protected ResponseService $responseService;



    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
        $this->apiKey = config('services.lastfm.api_key');
        $this->baseUrl = config('services.lastfm.base_url');
        $this->client = new Client();
    }


    public  function getLastFmApiRequest($apiMethod , $searchParameter , $apiType ,  $additionalParams = []){

        try {

            $query = array_merge([
                'api_key' => $this->apiKey,
                'method' => $apiMethod,
                $apiType => $searchParameter,
                'format' => 'json',
            ], $additionalParams);

            $response = $this->client->get($this->baseUrl, ['query' => $query]);

            return json_decode($response->getBody(), true);

        }catch(\Exception $exception){

                Log::error('Last Fm API Connection  Error: ' . $exception->getMessage());

            return $this->responseService->errorResponse('Last Fm API Connection');

        }

    }

    public function getLastFmApiClient($apiMethod, $searchParameter, $apiType)
    {
        return $this->getLastFmApiRequest($apiMethod, $searchParameter, $apiType);
    }

    public function getLastFmApiAlbum($apiMethod, $searchParameter, $apiType, $artistName)
    {
        $additionalParams = ['artist' => $artistName];
        return $this->getLastFmApiRequest($apiMethod, $searchParameter, $apiType, $additionalParams);

    }
}
