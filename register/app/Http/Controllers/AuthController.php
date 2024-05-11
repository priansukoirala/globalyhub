<?php

namespace App\Http\Controllers;

use App\ApiCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = request(['username', 'password']);
        if (auth()->attempt($credentials)) {
            $tokenResult = auth()->user()->createToken('register');
            // Check if system verified
            // super admin login case

            return $this->respondWithToken($tokenResult);
        }

        return $this->respondUnAuthenticated(ApiCode::INVALID_CREDENTIALS);
    }

    public function respondWithToken($tokenResult)
    {
        return $this->respond([
            'token' => $tokenResult->accessToken,
            'access_type' => 'bearer',
            'expires_in' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
}
