<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $checkLogin = Auth::attempt(['email' => $email, 'password' => $password]);

        if ($checkLogin) {
            $user = Auth::user();

            $token = $user->createToken('ten_token')->accessToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                "msg" => "Logged in successfully",
            ], 400);
        } else {

            return response()->json(["msg" => "Login failed!"], 400);
        }
    }

    public function logout(Request $request)
    {
        if(Auth::user()->token()->revoke()){
            return response()->json([
                'msg' => "Logout successfully",
            ], 200);
        }else {
            return response()->json([
                'msg' => "Error",
            ], 400);
        }
    }
}
