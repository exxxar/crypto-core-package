<?php


namespace Cryptolib\CryptoCore\forms;


use Carbon\Carbon;
use DateTime;

class PackedDataForm
{
    protected $outputUserData;
    protected $outputTrustedDeviceData;


    public function __construct(int $outputNumer, bool $isUnblockingAllowed)
    {
        $checksumUserData = crc32(0x8000 . "" . (new Carbon())->timestamp . "22" . $outputNumer);

        $this->outputUserData = pack("nJNNN", 0x8000,
            (new Carbon())->timestamp,
            22,
            $outputNumer,
            $checksumUserData
        );

        $outputPayload = $isUnblockingAllowed ? 0x01 : 0x00;

        $checksumTrustedDeviceData = crc32(0x4001 . "" . (new Carbon())->timestamp . "17" . $outputPayload);

        $this->outputTrustedDeviceData = pack("nJNCN", 0x4001,
            (new Carbon())->timestamp,
            17,
            $outputPayload,
            $checksumTrustedDeviceData
        );

    }

    public function getOutputUserData()
    {
        return base64_encode($this->outputUserData);
    }

    public function getOutputTrustedDeviceData()
    {
        return base64_encode($this->outputTrustedDeviceData);
    }

}
