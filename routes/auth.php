<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return ["user" => new UserResource($request->user())];
});

Route::get('/get-token', function (Request $request) {
    $token = $request->cookie('token');
    if (!$token) {
        return response()->json([
            "message" => "Unauthenticated",
            "status_code" => 401,
            "status_text" => "unauthenticated"
        ]);
    }
    return response()->json([
        "status_code" => 200,
        "status_text" => "OK",
        "token" => $token,
    ], 200);
});
Route::post("/auth/register", [AuthController::class, "register"]);
Route::post("/auth/login", [AuthController::class, "login"]);
Route::post("/auth/logout", [AuthController::class, "logout"]);
