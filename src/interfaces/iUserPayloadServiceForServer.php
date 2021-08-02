<?php


namespace Cryptolib\CryptoCore\interfaces;


use Cryptolib\CryptoCore\forms\EncryptedDataForm;
use Cryptolib\CryptoCore\forms\HandlerResultForm;
use Cryptolib\CryptoCore\forms\PayloadDataForm;
use Cryptolib\CryptoCore\Forms\TransferDataForm;
use Cryptolib\CryptoCore\Forms\TransferForm;

interface iUserPayloadServiceForServer
{
    public function getTrustedDevicePublicId(): TransferDataForm;

    public function onceEncryptedRequest(): TransferDataForm;

    public function handler(String $trustedDevicePublicId, TransferForm $transfer): HandlerResultForm;

    public function twiceEncryptedRequest(TransferDataForm $transfer): TransferDataForm;

    public function twiceEncryptedPermission(TransferDataForm $transfer): TransferDataForm;

    public function decryptData(String $trustedDevicePublicId, TransferForm $transfer): PayloadDataForm;

    public function encryptData(String $trustedDevicePublicId, EncryptedDataForm $transfer): String;


}
