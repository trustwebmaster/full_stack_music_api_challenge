<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService {


    public  static function getUserByEmail($email){
        return User::where('email', $email)->first();

    }

    public static function createUser($userData){

        return User::create([
                 'name' => $userData->name,
                 'email' => $userData->email,
                 'password' => Hash::make(rand(100000,999999))
             ]);


    }

}
