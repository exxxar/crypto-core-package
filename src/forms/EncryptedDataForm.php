<?php


namespace Cryptolib\CryptoCore\forms;


class EncryptedDataForm
{
    private $trustedDeviceData;
    private $userData;
    private $type;

    public function __construct()
    {
        $this->type = -1;
        $this->userData = "";
        $this->trustedDeviceData = null;

    }


    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function getUserDataInBase64(): String
    {
        return $this->userData;
    }

    public function getTrustedDeviceDataInBase64(): String
    {
        return $this->trustedDeviceData;
    }


    public function getTrustedDeviceData(): String
    {
        if (!is_null($this->trustedDeviceData)) {
            return base64_decode($this->trustedDeviceData);
        } else {
            return "";
        }
    }

    public function getUserData(): String
    {
        return base64_decode($this->userData);
    }

    public function setUserData(String $userData)
    {
        $this->userData = base64_encode($userData);
    }

    public function setTrustedDeviceData(String $trustedDeviceData)
    {
        $this->trustedDeviceData = base64_encode($trustedDeviceData);
    }

    public function setUserDataBase64(String $base64userData)
    {
        $this->userData = $base64userData;
    }

    public function setTrustedDeviceDataBase64(String $base64trustedDeviceData)
    {
        $this->trustedDeviceData = $base64trustedDeviceData;
    }

    public function toJSON()
    {
        return (object)[
            "type" => $this->type,
            "userData" => $this->userData,
            "trustedDeviceData" => $this->trustedDeviceData ?? null
        ];
    }

    public function toBase64JSON(): String
    {
        return base64_encode([
            "type" => $this->type,
            "userData" => $this->userData,
            "trustedDeviceData" => $this->trustedDeviceData ?? null
        ]);
    }


}
