<?php

namespace App\Http\Controllers\API\V1\SocialAuth;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleAuthService;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class GoogleCallbackController extends Controller
{
    protected GoogleAuthService $googleAuthService;

    /**
     * Handle the incoming request.
     */

    public function __construct(GoogleAuthService $googleAuthService)
    {
        $this->googleAuthService = $googleAuthService;
    }

    public function __invoke()
    {
        $googleSocialUser = $this->googleAuthService->callBack();

        if (!$googleSocialUser instanceof User) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid user type'
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Create a token
        $tokenResult = $googleSocialUser->createToken('googleSignIn' , ['*'], now()->addWeek());
        $accessToken = $tokenResult->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $googleSocialUser,
            'access_token' => $accessToken
        ], ResponseAlias::HTTP_OK);

    }

}
