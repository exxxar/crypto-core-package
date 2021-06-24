<?php


namespace Cryptolib\CryptoCore\forms;


class PayloadDataForm
{

    protected $transferDataForm; //TransferForm
    protected $userData;
    protected $trustedDeviceData;


    public function __construct()
    {

       $this->transferDataForm = null;
        $this->userData = null;
        $this->trustedDeviceData = null;
    }

    /**
     * @return mixed
     */
    public function getTransferDataForm(): TransferDataForm
    {
        return $this->transferDataForm;
    }

    /**
     * @param mixed $transferDataForm
     */
    public function setTransferDataForm(TransferDataForm $transferDataForm)
    {
        $this->transferDataForm = $transferDataForm;
    }

    /**
     * @return mixed
     */
    public function getUserData(): string
    {
        return $this->userData;
    }

    /**
     * @param mixed $userData
     */
    public function setUserData(string $userData)
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
    public function setTrustedDeviceData(string $trustedDeviceData)
    {
        $this->trustedDeviceData = $trustedDeviceData;
    }


    public function getUnpackedUserData(): UnpackedDataForm
    {
        return !is_null($this->getUserData())?new UnpackedDataForm($this->getUserData()):null;
    }

    public function getUnpackedTrustedDeviceData(): UnpackedDataForm
    {
        return !is_null($this->getUserData())?new UnpackedDataForm($this->getTrustedDeviceData()):null;
    }

    public function getPayload()
    {
        return !is_null($this->getUserData())?$this->getUnpackedUserData()->getPayloadData(): null;
    }

}
