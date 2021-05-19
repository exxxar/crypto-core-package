<?php

namespace Cryptolib\CryptoCore\Controllers;

use App\Http\Controllers\Controller;
use CryptoCore\Classes\UserPayloadServiceForServer;
use CryptoCore\Models\Connection;
use CryptoCore\Models\Resources\TransferCollection;
use CryptoCore\Models\Resources\TransferResource;
use CryptoCore\Models\Transfer;
use CryptoCore\Requests\TransferStoreRequest;
use CryptoCore\Requests\TransferUpdateRequest;
use Cryptolib\CryptoCore\Exceptions\ResponseStatusException;
use Cryptolib\CryptoCore\forms\ErrorForm;
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
     * @return TransferResource
     * @throws ResponseStatusException
     */
    public function store(TransferStoreRequest $request)
    {

        $connections = Connection::where("user_id", $request->sender_user_id)->get();

        if (count($connections) === 0)
            throw new ResponseStatusException("Ошибка подключения", "Отправитель не подключен к устойству", 403);

        $transfer = Transfer::create($request->validated());
        $transfer->status = (new ErrorForm(0))->toJSON();
        $transfer->save();

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
        /*


                if (transfers.isEmpty()) {
                    JSONObject res = new JSONObject();
                    res.put("res", null);

                    return new ResponseEntity<>(res, HttpStatus.OK);
                }

                List<JSONObject> tmpTransfers = new ArrayList<>();

                for (Transfer transfer : transfers) {

                    HandlerResultForm hrf = userPayloadServiceForServer.handler(transfer.getTransferForm());

                    String data = hrf.getData();

                    JSONObject tmpObject = new JSONObject();

                    tmpObject.put("decodedRecipientUserId", transfer.getRecipientUserId());
                    tmpObject.put("decodedSenderUserId", transfer.getSenderUserId());
                    tmpObject.put("senderUserId", transfer.getSenderUserId());
                    tmpObject.put("data", data);
                    tmpObject.put("type", transfer.getTransferType());
                    tmpObject.put("recivedData", "");
                    tmpObject.put("createDateTime", transfer.getCreateDateTime());

                    tmpTransfers.add(tmpObject);
                }

                JSONObject res = new JSONObject();

                res.put("res", tmpTransfers.toArray());

                return new ResponseEntity<>(res, HttpStatus.OK);*/
    }


    public function getInfoUser($userId)
    {
        /*@RequestMapping(value = "/info/{id}", method = RequestMethod.GET)
            public ModelAndView infoUser(@PathVariable(value = "id") String userId)
                    throws UnsupportedEncodingException, ParseException,
                    InvalidKeyException, InvalidKeySpecException, NoSuchAlgorithmException,
                    InvalidAlgorithmParameterException, NoSuchPaddingException, BadPaddingException, IllegalBlockSizeException {
                ModelAndView modelAndView = new ModelAndView();

                List<Connection> connections = connectionRepository.findByActive(true);
                String tmpUserId = Base64.getEncoder().encodeToString(userId.getBytes());

                List<Transfer> transfers = transferRepository.findByRecipientUserIdOrSenderUserId(tmpUserId);
                List<JSONObject> tmpTransfers = new ArrayList();

                for (Transfer transfer : transfers) {

                    TransferDataForm tdf = userPayloadServiceForServer.dataRequest(transfer.getTransferDataForm());

                    String data = tdf.getData();
                    transferRepository.save(transfer);

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
        modelAndView.setViewName("admin/info");
        return modelAndView;
        }*/
    }

    public function createInfo(TransferStoreRequest $request){
     /*   @PostMapping("/info/create")
    public ResponseEntity<JSONObject> createServerTransferUI(@RequestBody TransferForm transferForm)
            throws UnsupportedEncodingException, ParseException,
            InvalidKeyException, InvalidKeySpecException, NoSuchAlgorithmException,
            InvalidAlgorithmParameterException, NoSuchPaddingException, BadPaddingException, IllegalBlockSizeException {

            if (transferForm.getRecipientUserId().equals("0")) {
                JSONObject obj = new JSONObject();
            obj.put("message", "error");
            return new ResponseEntity<>(obj, HttpStatus.NOT_FOUND);
        }

            Transfer transfer = new Transfer();
        transfer.setRecipientUserId(transferForm.getRecipientUserId());
        transfer.setSenderUserId(ownUserId);

        TransferDataForm tdf = new TransferDataForm();
        tdf.setType(InfoRequestType.data.getValue());
        tdf.setData(transferForm.getData());

        tdf = userPayloadServiceForServer.encryptedDataRequest("AA==", tdf);

        transfer.setData(tdf.toBase64JSON());
        transfer.setStatusType(0);
        transferRepository.save(transfer);

        JSONObject obj = new JSONObject();
        obj.put("message", "success");
        obj.put("recipientUserId", transfer.getRecipientUserId());
        obj.put("data", transfer.getData());
        return new ResponseEntity<>(obj, HttpStatus.OK);
    }*/
    }
}
