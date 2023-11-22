<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductsController;
use App\Http\Controllers\Api\v1\ProductTypeController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

// Route::prefix('v1')->middleware('throttle:60')->group(function () {
Route::prefix('v1')->group(function () {
    Route::controller(ProductsController::class)->group(function () {
        Route::get("/products", "index");
        Route::get("/products/{slug}", "show");
        Route::post("/products", "store");
        Route::patch("/products/{slug}/update", "update");
        Route::put("/products/{slug}/update", "update");
        Route::delete("products/{slug}/delete", "destroy");
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get("/categories", "index");
        Route::get("/categories/{slug}", "show");
        Route::post("/categories", "store");
        Route::patch("/categories/{slug}/update", "update");
        Route::put("/categories/{slug}/update", "update");
        Route::delete("/categories/{slug}/delete", "destroy");
    });
    Route::controller(ProductTypeController::class)->group(function () {
        Route::get("/products/types/all", "index");
        Route::get("/products/types/{slug}", "show");
        Route::post("/products/types/create", "store");
        Route::put("/products/types/{slug}/update", "update");
        Route::patch("/products/types/{slug}/update", "update");
        Route::delete("/products/types/{slug}/delete", "destroy");
    });
});
