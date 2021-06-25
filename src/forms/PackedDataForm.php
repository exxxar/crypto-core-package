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

        $outputPayload = $isUnblockingAllowed ? 0x01 : 0x00;

        $checksumUserData = crc32(0x8000 . "" . (new Carbon())->timestamp . "17" . $outputPayload);



        $this->outputUserData = pack("nJNCN", 0x8000,
            (new Carbon())->timestamp,
            17,
            $outputPayload,
            $checksumUserData
        );


        $checksumTrustedDeviceData = crc32(0x4001 . "" . (new Carbon())->timestamp . "22" . $outputNumer);

        $this->outputTrustedDeviceData = pack("nJNNN", 0x4001,
            (new Carbon())->timestamp,
            22,
            $outputNumer,
            $checksumTrustedDeviceData
        );

        if ($this->outputUserData === false)
            $this->outputUserData = "";

        if ($this->outputTrustedDeviceData === false)
            $this->outputTrustedDeviceData = "";

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
