<?php

namespace Cryptolib\CryptoCore\Controllers;

use App\Http\Controllers\Controller;

use Cryptolib\CryptoCore\Classes\UserPayloadServiceForServer;
use Cryptolib\CryptoCore\Events\HandlerResultFormEvent;
use Cryptolib\CryptoCore\Exceptions\ResponseStatusException;
use Cryptolib\CryptoCore\forms\ErrorForm;
use Cryptolib\CryptoCore\Forms\TransferForm;
use Cryptolib\CryptoCore\Models\Connection;
use Cryptolib\CryptoCore\Models\Resources\TransferCollection;
use Cryptolib\CryptoCore\Models\Resources\TransferResource;
use Cryptolib\CryptoCore\Models\Transfer;
use Cryptolib\CryptoCore\Requests\TransferStoreRequest;
use Cryptolib\CryptoCore\Requests\TransferUpdateRequest;
use Cryptolib\CryptoCore\services\TransferIsHandeled;
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
     * @return object
     * @throws ResponseStatusException
     */
    public function store(TransferStoreRequest $request)
    {

        $connections = Connection::where("user_id", $request->senderUserId)->get();

        if (count($connections) === 0)
            throw new ResponseStatusException("Ошибка подключения", "Отправитель не подключен к устойству", 403);

        $transfer = new Transfer;
        $transfer->sender_user_id = $request->senderUserId;
        $transfer->recipient_user_id = $request->recipientUserId;
        $transfer->data = $request->data;

        if ($request->status) {
            $transfer->status = json_encode((new ErrorForm($request->status['type'] ?? 0, $request->status['error'] ?? null))->toJSON());
        } else {
            $transfer->status = json_encode((new ErrorForm())->toJSON());
        }
        
        $transfer->save();

        $transferForm = new TransferForm(
            $transfer->id,
            $transfer->sender_user_id,
            $transfer->recipient_user_id,
            $transfer->data,
            $transfer->created_at,
            $transfer->updated_at
        );
        $transferForm->setStatus(json_decode($transfer->status));

        $hrf = $this->userPayloadService->handler($transferForm);

        event(new HandlerResultFormEvent($hrf));

        return response()->json((object)[
            "id" => $transfer->id//$hrf->getOutgoingTransfer()->getId(),
        ]);//new TransferResource($transfer);
    }


    public function showByUserId($userId)
    {
        $transfers = Transfer::where("sender_user_id", $userId)
            ->orWhere("recipient_user_id", $userId)
            ->get();

        $transfers_tmp = [];

        foreach ($transfers as $transfer) {
            $transferIsHandeled = new TransferIsHandeled($transfer);

            if ($transferIsHandeled->check())
                array_push($transfers_tmp, new TransferResource($transfer));
        }


        return response()->json($transfers_tmp);
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
        $transfer->sender_user_id = $request->senderUserId;
        $transfer->recipient_user_id = $request->recipientUserId;
        $transfer->data = $request->data;
        $transfer->status = $request->status;
        $transfer->save();

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

    public function changeTransferStatus($id, ErrorForm $status)
    {
        $transfer = Transfer::find($id);

        if (is_null($transfer)) {
            throw new ResponseStatusException("Ошибка трансфера", "Трансфер не найден", 404);
        }

        $transfer->status = $status;
        $transfer->save();

        return new TransferResource($transfer);

    }


    public function getServerTransfer($userId)
    {

        $transfers = Transfer::where("sender_user_id", $userId)
            ->orWhere("recipient_user_id", $userId)
            ->get();

        if (count($transfers) == 0)
            return response()->json($transfers);


        foreach ($transfers as $transfer) {

            $transferForm = new TransferForm(
                $transfer->id,
                $transfer->sender_user_id,
                $transfer->recipient_user_id,
                $transfer->data,
                $transfer->created_at,
                $transfer->updated_at
            );

            $hrf = $this->userPayloadService->handler($transferForm);

            $data = $hrf->getData();


            $tmpObject = (object)[
                "decodedRecipientUserId" => $transfer->getRecipientUserId(),
                "decodedSenderUserId" => $transfer->getSenderUserId(),
                "senderUserId" => $transfer->getSenderUserId(),
                "data" => $data,
                "recivedData" => "",
                "createDateTime" => $transfer->getCreateDateTime(),
            ];

        }

        return response()->json($tmpObject);
    }


    public function getInfoUser($userId)
    {

        /* $connections = Connection::where("active", true)->get();


                 $tmpUserId =base64_encode($userId);

                 $transfers = Transfer::where("sender_user_id",$tmpUserId)
                     ->orWhere("recipient_user_id", $tmpUserId)
                     ->get();

                 foreach ($transfers as $transfer) {

             $tdf = $this->userPayloadService->dataRequest($transfer);//transfer.getTransferDataForm()

                     $data = $tdf->getData();

                     JSONObject tmpObject = new JSONObject();
                     tmpObject.put("status", "");
                     tmpObject.put("id", transfer.getId());
                     tmpObject.put("recipientUserId", transfer.getRecipientUserId());
                     tmpObject.put("decodedRecipientUserId", transfer.getRecipientUserId());
                     tmpObject.put("decodedSenderUserId", transfer.getSenderUserId());
                     tmpObject.put("senderUserId", transfer.getSenderUserId());
                     tmpObject.put("data", data);
                     tmpObject.put("recivedData", "");
                     tmpObject.put("createDateTime", transfer.getCreateDateTime());

                 }

         modelAndView.addObject("connections", connections);
         modelAndView.addObject("transfers", tmpTransfers);
         modelAndView.addObject("ownid", ownUserId);
         modelAndView.addObject("userid", userId);
         modelAndView.setViewName("admin/info");*/

    }

    public function createInfo(TransferStoreRequest $request)
    {
        /*   @PostMapping("/info/create")
         * public ResponseEntity<JSONObject> createServerTransferUI(@RequestBody TransferForm transferForm)
         * throws UnsupportedEncodingException, ParseException,
         * InvalidKeyException, InvalidKeySpecException, NoSuchAlgorithmException,
         * InvalidAlgorithmParameterException, NoSuchPaddingException, BadPaddingException, IllegalBlockSizeException {
         *
         * if (transferForm.getRecipientUserId().equals("0")) {
         * JSONObject obj = new JSONObject();
         * obj.put("message", "error");
         * return new ResponseEntity<>(obj, HttpStatus.NOT_FOUND);
         * }
         *
         * Transfer transfer = new Transfer();
         * transfer.setRecipientUserId(transferForm.getRecipientUserId());
         * transfer.setSenderUserId(ownUserId);
         *
         * TransferDataForm tdf = new TransferDataForm();
         * tdf.setType(InfoRequestType.data.getValue());
         * tdf.setData(transferForm.getData());
         *
         * tdf = userPayloadServiceForServer.encryptedDataRequest("AA==", tdf);
         *
         * transfer.setData(tdf.toBase64JSON());
         * transfer.setStatusType(0);
         * transferRepository.save(transfer);
         *
         * JSONObject obj = new JSONObject();
         * obj.put("message", "success");
         * obj.put("recipientUserId", transfer.getRecipientUserId());
         * obj.put("data", transfer.getData());
         * return new ResponseEntity<>(obj, HttpStatus.OK);
         * }*/
    }
}
