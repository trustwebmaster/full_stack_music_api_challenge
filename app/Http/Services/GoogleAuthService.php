<?php

namespace App\Http\Services;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GoogleAuthService {

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function callBack(){

        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            $existingUser = $this->userService->getUserByEmail($googleUser->email);

            if (!$existingUser) {
                $existingUser = $this->userService->createUser($googleUser);
                Log::error('created User' . json_encode($existingUser));


            }

            return $existingUser;

        }catch (\Exception $exception){

            Log::error('Google OAuth Callback Error: ' . $exception->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Google OAuth Callback Error'],
                    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR

            );
        }

    }
}
