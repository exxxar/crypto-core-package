<?php


namespace Cryptolib\CryptoCore\forms;


class PayloadDataForm
{

    protected $transferDataForm; //TransferForm
    protected $userData;
    protected $trustedDeviceData;

    /**
     * @return mixed
     */
    public function getTransferDataForm():TransferDataForm
    {
        return $this->transferDataForm;
    }

    /**
     * @param mixed $transferDataForm
     */
    public function setTransferDataForm($transferDataForm)
    {
        $this->transferDataForm = $transferDataForm;
    }

    /**
     * @return mixed
     */
    public function getUserData():string
    {
        return $this->userData;
    }

    /**
     * @param mixed $userData
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;
    }

    /**
     * @return mixed
     */
    public function getTrustedDeviceData(): string
    {
        return $this->trustedDeviceData;
    }

    /**
     * @param mixed $trustedDeviceData
     */
    public function setTrustedDeviceData($trustedDeviceData)
    {
        $this->trustedDeviceData = $trustedDeviceData;
    }


    public function getUnpackedData(): UnpackedUserDataForm
    {
        return new UnpackedUserDataForm($this->getUserData());
    }


}
