<?php

namespace App\Http\Controllers\API\V1\SocialAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GoogleRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $redirectUrl = Socialite::driver('google')
                                 ->stateless()
                                 ->redirect()
                                 ->getTargetUrl();

        return response()->json([
            'success' => true,
            'url' => $redirectUrl],
            ResponseAlias::HTTP_OK
       );

    }

}
