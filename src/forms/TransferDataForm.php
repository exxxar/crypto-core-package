<?php


namespace Cryptolib\CryptoCore\Forms;


use Cryptolib\CryptoCore\Models\Transfer;

class TransferDataForm
{
    private $type;
    private $data;

    public function __construct($type=null, $base64data=null)
    {
        $this->type = $type;
        $this->data = base64_encode($base64data);
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getDataInBase64()
    {
        return $this->data;
    }

    public function getData()
    {
        return base64_decode($this->data);
    }


    public function setData($data)
    {
        $this->data = base64_encode($data);
    }


    public function setDataBase64($base64data)
    {
        $this->data = $base64data;
    }

    public function toSimpleJSON()
    {
        $obj = (object)[
            "type" => $this->type
        ];

        return $obj;
    }

    public function toBase64JSON() {
        return base64_encode((string)$this->toJSON());
    }


    public function toJSON()
    {
        $obj = ["type" => $this->type];

        if (!empty($this->data))
            $obj["data"] = $this->data;

        return (object)$obj;
    }


}
