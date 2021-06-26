<?php


namespace Cryptolib\CryptoCore\forms;


use Carbon\Carbon;
use Cryptolib\CryptoCore\classes\int_helper;
use DateTime;

class PackedDataForm
{
    protected $outputUserData;
    protected $outputTrustedDeviceData;


    public function __construct(int $outputNumer, bool $isUnblockingAllowed)
    {

        $outputPayload = $isUnblockingAllowed ? 0x01 : 0x00;

        $checksumUserData = crc32(0x8000
            . int_helper::uInt64((new Carbon())->timestamp, true)
            . int_helper::uInt32(17, true)
            . int_helper::uInt8($outputPayload)
        );

        $this->outputUserData = pack("nJNCN", 0x8000,
            (new Carbon())->timestamp,
            17,
            $outputPayload,
            $checksumUserData
        );


        $checksumTrustedDeviceData = crc32(0x4001
            . int_helper::uInt64((new Carbon())->timestamp, true)
            . int_helper::uInt32(22, true)
            . int_helper::uInt32($outputNumer, true)
        );

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
