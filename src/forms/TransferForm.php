<?php


namespace Cryptolib\CryptoCore\Forms;


class TransferForm
{
    private $id;

    private $senderUserId;

    private $recipientUserId;

    private $data;

    private $status;

    private $createDateTime;

    private $updateDateTime;

    public function __construct(int $id,int $senderUserId,int $recipientUserId, $data, $createDateTime, $updateDateTime)
    {
        $this->id = $id;
        $this->senderUserId = $senderUserId;
        $this->recipientUserId = $recipientUserId;
        $this->data = $data;
        $this->createDateTime = $createDateTime;
        $this->updateDateTime = $updateDateTime;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSenderUserId()
    {
        return $this->senderUserId;
    }

    public function setSenderUserId($senderUserId)
    {
        $this->senderUserId = $senderUserId;
    }

    public function getRecipientUserId()
    {
        return $this->recipientUserId;
    }

    public function setRecipientUserId($recipientUserId)
    {
        $this->recipientUserId = $recipientUserId;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getCreateDateTime()
    {
        return $this->createDateTime;
    }

    public function setCreateDateTime($createDateTime)
    {
        $this->createDateTime = $createDateTime;
    }

    public function getUpdateDateTime()
    {
        return $this->updateDateTime;
    }

    public function setUpdateDateTime($updateDateTime)
    {
        $this->updateDateTime = $updateDateTime;
    }

    public function toJSON()
    {

        $tmp = [
            "id" => $this->id,
            "senderUserId" => $this->senderUserId,
            "recipientUserId" => $this->recipientUserId,
            "data" => $this->data,

        ];

        if (!is_null($this->status))
            $tmp["status"] = $this->status;

        return (object)$tmp;
    }

    public function getTransferDataForm()
    {
        $tdf = new TransferDataForm($this->getTransferType());


        if ($this->data == null || strlen($this->data) <= 3) {
            $tdf->setData("");
            return $tdf;
        }

        try {
            base64_decode($this->data);
            $tdf->setDataBase64($this->data);
        } catch (\Exception $e) {
            $tdf->setData($this->data);
        }

        return $tdf;
    }


    public function getTransferType()
    {
        if ($this->getStatus() == null) {
            return -1;
        }

        return $this->getStatus()->type;

    }

    public function getDataType()
    {
        try {
            return json_decode(base64_decode($this->getData()))->type;
        } catch (\Exception $ex) {
            return 0;
        }
    }

    public function setStatusType($type)
    {

        $this->status = ["type", $type];
    }

}
