<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request has a valid access token
        $token = $request->bearerToken();

        // Attempt to authenticate the user using Sanctum
        if (!$token) {
            return response()->json([
                "message" => "You are not authorized to make this request"
            ], 403);
        }

        // Use Sanctum's token model to authenticate the user
        $user = Auth::guard('sanctum')->user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                "message" => "You are not authorized to make this request"
            ], 403);
        }

        if ($user->role->id === 2) {
            // Assign the user to a variable in the request
            $request->merge(['user' => $user]);
            return $next($request);
        }
        return response()->json([
            "message" => "You are not authorized to make this request"
        ], 403);
    }
}
