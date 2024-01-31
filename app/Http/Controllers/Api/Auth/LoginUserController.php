<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\HttpResponse;
use App\Helpers\UserCookie;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class LoginUserController extends Controller
{
    use HttpResponse, UserCookie;

    public function __construct()
    {
        return $this->middleware('auth:sanctum')->only('logout');
    }

    public function login(LoginUserRequest $request)
    {
        // Accept only email and password
        $request->only(["email", "password"]);

        // Check password
        if (!auth()->attempt($request->only(["email", "password"]))) {
            return response()->json([
                "errors" => [
                    "password" => ["Wrong password."]
                ]
            ], 422);
        }

        // user
        $user = User::where("email", $request->email)->first();

        // Create cookie
        [$token, $cookie, $token_exp_time] = $this->createCookie($user);

        // Response success
        return $this->success([
            "user" => new UserResource($user),
            "token" => $token,
            "expired_at" => $token_exp_time->diffForHumans()
        ], 200)->withCookie($cookie);
    }

    public function logout()
    {
        // Delete access token
        auth()->user()->currentAccessToken()->delete();

        return $this->success([], 204)->withCookie(Cookie::forget('token'));
    }
}
