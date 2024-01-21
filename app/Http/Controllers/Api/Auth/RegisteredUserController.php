<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\HttpResponse;
use App\Helpers\UserCookie;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class RegisteredUserController extends Controller
{

    use HttpResponse, UserCookie;

    public function store(StoreUserRequest $request)
    {
        // Accept only [name, email, password]
        $request->only(["name", "username", "email", "password", "address", "phone_no"]);

        // Create user
        $user = User::create([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => $request->password,
            "address" => $request->address ?? NULL,
            "phone_no" => $request->phone_no ?? NULL,
            "role_id" => 1
        ]);

        // Create cookie
        [$token, $cookie, $token_exp_time] = $this->createCookie($user);

        // Response Success
        return $this->success([
            "user" => new UserResource($user),
            "token" => $token,
            "expired_at" => $token_exp_time->diffForHumans()
        ], 200)->withCookie($cookie);
    }
}
