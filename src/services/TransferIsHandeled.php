<?php

namespace Cryptolib\CryptoCore\services;

use Cryptolib\CryptoCore\Models\Transfer;

class TransferIsHandeled
{
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function check()
    {
        $statusObject = (object) $this->transfer->status;

        if ($statusObject->type == 0) {
            return false;
        }
        return true;
    }

    public function getError()
    {
        // TODO return error from transfer status
    }
}