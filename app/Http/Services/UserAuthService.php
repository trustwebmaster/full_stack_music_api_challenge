<?php


namespace App\Http\Services;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class UserAuthService {



    public function createUser(array $data){

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

    }

    public function attemptLogin(Request $request){

        $remember = $request->input(['remember', false]);
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials, $remember)) {
            return Auth::user();
        }

        throw new UnauthorizedException('Invalid credentials');

    }



}
