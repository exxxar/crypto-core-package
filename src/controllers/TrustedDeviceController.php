<?php

namespace Cryptolib\CryptoCore\Controllers;

use App\Http\Controllers\Controller;

use Cryptolib\CryptoCore\Classes\UserPayloadServiceForServer;
use Cryptolib\CryptoCore\events\HandleMSEvent;
use Cryptolib\CryptoCore\events\HandlerResultFormEvent;
use Cryptolib\CryptoCore\Exceptions\ResponseStatusException;
use Cryptolib\CryptoCore\forms\ErrorForm;
use Cryptolib\CryptoCore\Forms\TransferForm;
use Cryptolib\CryptoCore\Models\Connection;
use Cryptolib\CryptoCore\Models\Resources\TransferCollection;
use Cryptolib\CryptoCore\Models\Resources\TransferResource;
use Cryptolib\CryptoCore\Models\Transfer;
use Cryptolib\CryptoCore\Requests\TransferStoreRequest;
use Cryptolib\CryptoCore\Requests\TransferUpdateRequest;
use Illuminate\Http\Request;

class TrustedDeviceController extends Controller
{

    protected $userPayloadService;


    public function __construct()
    {
        $this->userPayloadService = new UserPayloadServiceForServer();
    }

    public function getTrustedDeviceList(){
        return response()->json($this->userPayloadService->getTrustedDeviceList());
    }


}
