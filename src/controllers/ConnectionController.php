<?php

namespace Cryptolib\CryptoCore\Controllers;

use App\Http\Controllers\Controller;
use Cryptolib\CryptoCore\Models\Connection;
use Cryptolib\CryptoCore\Models\Resources\ConnectionCollection;
use Cryptolib\CryptoCore\Models\Resources\ConnectionResource;
use Cryptolib\CryptoCore\Requests\ConnectionStoreRequest;
use Cryptolib\CryptoCore\Requests\ConnectionUpdateRequest;
use Cryptolib\CryptoCore\Exceptions\ResponseStatusException;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ConnectionCollection
     */
    public function index()
    {
        $connections = Connection::all();

        return new ConnectionCollection($connections);
    }

    public function active()
    {
        $connections = Connection::where("active", true)->get();

        return new ConnectionCollection($connections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->noContent();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ConnectionResource
     * @throws ResponseStatusException
     */
    public function store(ConnectionStoreRequest $request)
    {
        $connection = Connection::where("device_id", $request->device_id)
            ->where("user_id", $request->user_id)
            ->where("active", true)
            ->first();

        if (!is_null($connection))
            throw new ResponseStatusException("Ошибка соединения", "Соединение уже существует", 423);

        $old_user_connections = Connection::where("user_id", $request->user_id)
            ->where("active", true)
            ->get();

        foreach ($old_user_connections as $old_user_connection) {
            $old_user_connection->active = false;
            $old_user_connection->save();
        }

        $connection = Connection::create($request->validated());

        return new ConnectionResource($connection);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Connection $connection
     * @return ConnectionResource
     */
    public function show($id)
    {
        $connection = Connection::find($id);

        return new ConnectionResource($connection);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Connection $connection
     * @return \Illuminate\Http\Response
     */
    public function edit(Connection $connection)
    {
        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Connection $connection
     * @return ConnectionResource
     */
    public function update(ConnectionUpdateRequest $request, $id)
    {
        $connection = Connection::find($id);
        $connection->update($request->validated());

        return new ConnectionResource($connection);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Connection $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $deviceId)
    {
        $connection = Connection::where("user_id", $userId)
            ->where("device_id", $deviceId)
            ->first();

        if (is_null($connection))
            throw new ResponseStatusException("Ошибка соединения", "Соединение не найдено", 404);

        $connection->active = false;
        $connection->save();

        return response()->noContent();
    }

    public function clearAll()
    {
        Connection::truncate();
        return response()->noContent();
    }
}
