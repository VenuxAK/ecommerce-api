<?php

use App\Http\Controllers\Api\Auth\LoginUserController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

Route::middleware(['auth.api.admin'])->get('/user', function (Request $request) {
    return response()->json([
        "user" => new UserResource($request->user)
    ]);
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
Route::post("/auth/register", [RegisteredUserController::class, "store"]);
Route::post("/auth/login", [LoginUserController::class, "login"]);
Route::post("/auth/logout", [LoginUserController::class, "logout"]);
