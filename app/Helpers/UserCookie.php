<?php

namespace App\Helpers;

trait UserCookie
{

    protected function createCookie($user)
    {
        $token_name = "Token of $user->name";
        $token_exp_time = now()->addMinutes(env('SESSION_LIFETIME', 60));
        $token = $user->createToken(
            $token_name,
            ["*"],
            $token_exp_time
        )->plainTextToken;

        $cookie = cookie(
            'token',
            $token,
            env('SESSION_LIFETIME', 60),
            "/",
            null,
            false,
            true
        );

        return [
            $token, $cookie, $token_exp_time
        ];
    }
}
