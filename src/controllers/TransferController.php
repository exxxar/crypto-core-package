<?php

namespace Cryptolib\CryptoCore\Controllers;

use App\Http\Controllers\Controller;
use CryptoCore\Classes\UserPayloadServiceForServer;
use CryptoCore\Forms\TransferDataForm;
use CryptoCore\Models\Resources\TransferCollection;
use CryptoCore\Models\Resources\TransferResource;
use CryptoCore\Models\Transfer;
use CryptoCore\Requests\TransferStoreRequest;
use CryptoCore\Requests\TransferUpdateRequest;
use Cryptolib\CryptoCore\Exceptions\ResponseStatusException;
use Illuminate\Http\Request;

class TransferController extends Controller
{

    protected $userPayloadService;


    public function __construct()
    {
        $this->userPayloadService = new UserPayloadServiceForServer();
    }

    /**
     * Display a listing of the resource.
     *
     * @return TransferCollection
     */
    public function index()
    {
        $transfers = Transfer::all();

       // $tdf = new TransferDataForm();
        return new TransferCollection($transfers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferStoreRequest $request)
    {
        $transfer = Transfer::create($request->validated());
        return new TransferResource($transfer);
    }


    public function showByUserId($userId)
    {
        $transfer = Transfer::where("user_id", $userId)->get();

        return new TransferCollection($transfer);
    }

    public function showByTransferId($transferId)
    {
        $transfer = Transfer::where("id", $transferId)->first();

        return new TransferResource($transfer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Transfer $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        //
    }


    public function update(TransferUpdateRequest $request, $id)
    {
        $transfer = Transfer::find($id);
        $transfer->update($request->validated());

        return new TransferResource($transfer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transfer $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        //
    }

    public function clear()
    {

    }

    public function changeTransferStatus($id)
    {
        $transfer = Transfer::find($id);

        if (is_null($transfer))
            throw new ResponseStatusException("Ошибка трансфера", "Трансфер не найден", 404);


    }
}
