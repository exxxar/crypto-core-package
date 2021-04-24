<?php


use Illuminate\Support\Facades\Route;


Route::group(["prefix" => "connections"], function () {
    Route::get("/", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->name("connections.list")->middleware(["x-api:0.0.3"]);
    Route::post("/", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->name("connections.add")->middleware(["x-api:0.0.3"]);
    Route::get("/active", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->name("connections.actives")->middleware(["x-api:0.0.3"]);
    Route::delete("/{userId}/{deviceId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->name("connections.delete")->middleware(["x-api:0.0.3"]);
});

Route::group(["prefix" => "transfers"], function () {
    Route::get("/", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::post("/", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::get("/info", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::post("/info/create", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::get("/clear", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::post("/status/{transferId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->where(["transferId" => "[0-9]{1,100}"])->middleware(["x-api:0.0.3"]);
    Route::get("/transfer/get/{transferId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->where(["transferId" => "[0-9]{1,100}"])->middleware(["x-api:0.0.3"]);
    Route::get("/user/get/{userId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::get("/user/all/{userId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->middleware(["x-api:0.0.3"]);
    Route::get("/transfer/all/{transferId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
        ->where(["transferId" => "[0-9]{1,100}"])->middleware(["x-api:0.0.3"]);
});



