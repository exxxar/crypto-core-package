<?php


namespace Cryptolib\CryptoCore\interfaces;


use Cryptolib\CryptoCore\forms\HandlerResultForm;
use Cryptolib\CryptoCore\Forms\TransferDataForm;
use Cryptolib\CryptoCore\Forms\TransferForm;

interface iUserPayloadServiceForServer
{
    public function getTrustedDevicePublicId(): array;

    public function onceEncryptedRequest(): array;

    public function handler(TransferForm $transfer): HandlerResultForm;

    public function twiceEncryptedRequest(TransferDataForm $transfer): array;

    public function twiceEncryptedPermission(TransferDataForm $transfer): array;

    public function dataRequest(TransferDataForm $transfer): TransferDataForm;

    public function encryptedDataRequestV1($trustedDeviceData, TransferDataForm $transfer): TransferDataForm;


}
