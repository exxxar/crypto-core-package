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

        $pack = int_helper::uInt16(0x8000, true)
            . int_helper::uInt64((new Carbon())->timestamp, true)
            . int_helper::uInt32(19, true)
            . int_helper::uInt8($outputPayload);

        $checksumUserData = crc32($pack);

        $this->outputUserData = $pack . int_helper::uInt32($checksumUserData, true);

        $pack = int_helper::uInt16(0x4001, true)
            . int_helper::uInt64((new Carbon())->timestamp, true)
            . int_helper::uInt32(19, true)
            . int_helper::uInt8($outputNumer, true);

        $checksumTrustedDeviceData = crc32($pack);

        $this->outputTrustedDeviceData = $pack . int_helper::uInt32($checksumTrustedDeviceData, true);

        if ($this->outputUserData === false)
            $this->outputUserData = "";

        if ($this->outputTrustedDeviceData === false)
            $this->outputTrustedDeviceData = "";

    }

    public function initForSettings(int $id = 2,string $configData = "")
    {
        $outputPayload = 0x00;

        $pack = int_helper::uInt16(0x8001, true)
            . int_helper::uInt64((new Carbon())->timestamp, true)
            . int_helper::uInt32(19, true)
            . int_helper::uInt8($outputPayload);

        $checksumUserData = crc32($pack);

        $this->outputUserData = $pack . int_helper::uInt32($checksumUserData, true);

        $payload = int_helper::uInt16($id, true)
            . int_helper::uInt16(strlen($configData))
            . $configData;

        $pack = int_helper::uInt16(0x4000, true)
            . int_helper::uInt64((new Carbon())->timestamp, true)
            . int_helper::uInt32(18 + strlen($payload), true) //длина всех полей
            . $payload; //олезная нагрузка

        $checksumTrustedDeviceData = crc32($pack);

        $this->outputTrustedDeviceData = $pack . int_helper::uInt32($checksumTrustedDeviceData, true);
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
