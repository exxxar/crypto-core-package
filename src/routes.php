<?php


use Illuminate\Support\Facades\Route;


Route::get("/devices", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "index"])
    ->name("connections.list")->middleware(["x-api:0.0.3"]);

Route::get("/connection/{connectionId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "show"])
    ->name("connections.current")->middleware(["x-api:0.0.3"]);

Route::post("/devices", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "store"])
    ->name("connections.add")->middleware(["x-api:0.0.3"]);

Route::get("/activedevices", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "active"])
    ->name("connections.actives")->middleware(["x-api:0.0.3"]);

Route::delete("/devices/{userId}/{deviceId}", [Cryptolib\CryptoCore\Controllers\ConnectionController::class, "destroy"])
    ->name("connections.delete")->middleware(["x-api:0.0.3"]);


Route::get("/alltransfers", [Cryptolib\CryptoCore\Controllers\TransferController::class, "index"])
    ->name("transfers.all")
    ->middleware(["x-api:0.0.3"]);

Route::post("/transfer", [Cryptolib\CryptoCore\Controllers\TransferController::class, "store"])
    ->name("transfers.add")
    ->middleware(["x-api:0.0.3"]);

Route::get("/transfers/{userId}", [Cryptolib\CryptoCore\Controllers\TransferController::class, "showByUser"])
    ->name("transfers.show_by_user")
    ->middleware(["x-api:0.0.3"]);

Route::get("/transfer/{transferId}", [Cryptolib\CryptoCore\Controllers\TransferController::class, "show"])
    ->name("transfers.show")
    ->middleware(["x-api:0.0.3"]);

Route::get("/servertransfer/{userId}", [Cryptolib\CryptoCore\Controllers\TransferController::class, "getServerTransfers"])
    ->name("transfers.server_transfers")
    ->middleware(["x-api:0.0.3"]);

Route::post("/info/create", [Cryptolib\CryptoCore\Controllers\TransferController::class, "store"])
    ->middleware(["x-api:0.0.3"]);

Route::get("/clear", [Cryptolib\CryptoCore\Controllers\TransferController::class, "clear"])
    ->middleware(["x-api:0.0.3"]);

Route::post("/transfer/status/{transferId}", [Cryptolib\CryptoCore\Controllers\TransferController::class, "index"])
    ->where(["transferId" => "[0-9]{1,100}"])->middleware(["x-api:0.0.3"]);







