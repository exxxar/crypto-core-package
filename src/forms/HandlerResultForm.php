<?php


namespace Cryptolib\CryptoCore\forms;


class HandlerResultForm
{

    protected $incomingTransfer; //TransferForm
    protected $outgoingTransfer; //TransferForm
    protected $data;//String
    protected $payload;//String

    public function __construct(TransferForm $incoming = null)
    {
        $this->incomingTransfer = $incoming;
        $this->data = "";
        $this->payload = "";
        $this->outgoingTransfer = null;
    }


    public function getIncomingForm(): TransferForm
    {
        return $this->incomingTransfer;
    }

    public function setIncomingTransfer(TransferForm $incoming)
    {
        $this->incomingTransfer = $incoming;
    }

    public function getOutgoingTransfer(): TransferForm
    {
        return $this->outgoingTransfer;
    }

    public function setOutgoingTransfer(TransferForm $outgoing)
    {
        $this->outgoingTransfer = $outgoing;
    }

    public function getData(): String
    {
        return $this->data;
    }

    public function setData(String $data)
    {
        $this->data = $data;
    }


    public function getPayload(): String
    {
        return $this->payload;
    }

    public function setPayload(String $payload)
    {
        $this->payload = $payload;
    }


    public function toJSON()
    {
        return (object)[
            "data" => $this->data,
            "payload" => $this->payload,
            "incomingTransfer" => $this->incomingTransfer,
            "outgoingTransfer" => $this->outgoingTransfer,
        ];
    }
}
