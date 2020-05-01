<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where("email", "=", $email)->first();

        if (Hash::check($password, $user->password)) {

            return response()->json([
                "access_token" => $user->createToken("me")->accessToken,
                "user" => $user
            ], 200);

        } else {

            return response()->json([
                "error" => "email or password is wrong"
            ], 401);

        }
    }
}
