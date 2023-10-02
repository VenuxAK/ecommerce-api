<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-token', function (Request $request) {
    $token = $request->cookie('token');

    if ($token) {
        return response()->json([
            "status_code" => 200,
            "status_text" => "OK",
            "token" => $token,
        ], 200);
    }
    return response()->json([
        "message" => "Unauthenticated"
    ]);
});
Route::post("/auth/register", [AuthController::class, "register"]);
Route::post("/auth/login", [AuthController::class, "login"]);
Route::post("/auth/logout", [AuthController::class, "logout"]);

Route::prefix('v1')->group(function () {
    Route::controller(ProductsController::class)->group(function () {
        Route::get("/products", "index");
        Route::get("/products/{slug}", "show");
        Route::post("/products", "store");
        Route::patch("/products/{slug}/update", "update");
        Route::put("/products/{slug}/update", "update");
        Route::delete("products/{slug}/destroy", "destroy");
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get("/categories", "index");
        Route::get("/categories/{slug}", "show");
        Route::post("/categories", "store");
        Route::patch("/categories/{slug}/update", "update");
        Route::put("/categories/{slug}/update", "update");
        Route::delete("/categories/{slug}", "destroy");
    });
});
