<?php


namespace Cryptolib\CryptoCore\forms;


class EncryptedDataForm
{
    private $trustedDeviceData;
    private $userData;
    private $type;

    public function __construct()
    {
        $this->type = 7;
        $this->userData = "";
        $this->trustedDeviceData = null;

    }

    public function setPackedDataForm(PackedDataForm $packedDataForm){
        $this->setTrustedDeviceData($packedDataForm->getOutputTrustedDeviceData());
        $this->setUserData($packedDataForm->getOutputUserData());
    }


    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }


    public function getTrustedDeviceData(bool $needDecode = false): String
    {
        if (!is_null($this->trustedDeviceData)) {
            return $needDecode ? base64_decode($this->trustedDeviceData) : $this->trustedDeviceData;
        } else {
            return "";
        }
    }

    public function getUserData(bool $needDecode = false): String
    {
        return $needDecode ? base64_decode($this->userData) : $this->userData;
    }

    public function setUserData(String $userData, bool $needEncode = false)
    {
        $this->userData = $needEncode ? base64_encode($userData) : $userData;
    }

    public function setTrustedDeviceData(String $trustedDeviceData, bool $needEncode = false)
    {
        $this->trustedDeviceData = $needEncode ? base64_encode($trustedDeviceData) : $trustedDeviceData;
    }

    public function getTransferDataForm(): TransferDataForm{
        $tdf = new TransferDataForm();
        $tdf->setType($this->type);
        $tdf->setData($this->toBase64JSON());
        return $tdf;
    }

    public function toJSON()
    {
        return (object)[
            "type" => $this->getType(),
            "userData" => $this->getUserData() ?? base64_encode(""),
            "trustedDeviceData" => $this->getTrustedDeviceData() ?? base64_encode("")
        ];
    }

    public function toBase64JSON() {
        return base64_encode(json_encode($this->toJSON()));
    }



}
