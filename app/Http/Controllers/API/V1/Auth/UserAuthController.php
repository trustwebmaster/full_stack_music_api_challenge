<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthLoginRequest;
use App\Http\Requests\UserAuthStoreRequest;
use App\Http\Services\ResponseService;
use App\Http\Services\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserAuthController extends Controller
{
    protected ResponseService $responseService;
    protected UserAuthService $userAuthService;

    public function __construct(ResponseService $responseService, UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
        $this->responseService = $responseService;
    }

    public function register(UserAuthStoreRequest $request): JsonResponse
    {
        try {

            $user = $this->userAuthService->createUser($request->validated());
            $accessToken = $user->createToken('userSignIn')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $accessToken,
            ]);

        } catch (\Exception $exception) {
            Log::error('An Error occurred while creating user. Error: ' . $exception->getMessage());
            return $this->responseService->errorResponse('An error occurred while creating user');

        }
    }

    public function login(UserAuthLoginRequest $request): JsonResponse
    {
        try {
            $user = $this->userAuthService->attemptLogin($request);
            $accessToken = $user->createToken('userSignIn')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $accessToken,
            ]);

        } catch (\Exception $exception) {
            Log::error('An Error occurred while trying to login. Error: ' . $exception->getMessage());
            return $this->responseService->errorResponse('An error occurred while trying to login');

        }
    }
}
