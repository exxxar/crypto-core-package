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
        return new UnpackedDataForm($this->getUserData());
    }


    public function getUnpackedTrustedDeviceData(): UnpackedDataForm
    {
        return new UnpackedDataForm($this->getTrustedDeviceData());
    }

    public function getPayload()
    {
        return $this->getUnpackedUserData()->getPayloadData();
    }

}
