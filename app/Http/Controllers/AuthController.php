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

        if ($user == null){
            return response()->json([
                "error" => "email or password is wrong"
            ], 403);
        }

        if (Hash::check($password, $user->password)) {

            return response()->json([
                "access_token" => $user->createToken("me")->accessToken,
                "user" => $user
            ], 200);

        } else {

            return response()->json([
                "error" => "email used"
            ], 403);

        }
    }

    public function register(Request $request)
    {
$name =$request -> name;
$email =$request -> email;
$password =$request -> password;
$confirmـpassword =$request -> confirmـpassword;


$user = User::where("email", "=", $email);
if($email ==null){
    return response()->json([
        "error" => "email used"
    ], 403);
}




$numpass = strlen($password);

if($numpass > 4){
    return response()->json([
        "error" => " password is more than 4 "
    ], 400);

}if($numpass < 4){
    return response()->json([
        "error" => " password is less than 4 "
    ], 400);
}if ($password != $confirmـpassword){
    return response()->json([
        "error" => " password is missmatch"
    ], 400);
}

/*
$user->$name =$request -> name;
$user->$email =$request -> email;
$user->$password =$request -> password;
$user->balance  =0 ;
$user->save();
*/

$user = User::create([
    "name" =>  $name ,
    "email" => $email,
    "password" => bcrypt($password) ,
    "balance" => 0,
    

]);

return response()->json([
    "access_token" => $user->createToken("me")->accessToken,
    "user" => $user
], 200);
return $name;

    }

}