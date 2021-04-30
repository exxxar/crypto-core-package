<?php


namespace Cryptolib\CryptoCore\forms;


class ErrorForm
{

    private $type;

    private $error;

    public function __construct(int $type = 0, $error = null)
    {
        $this->type = $type;
        $this->error = $error;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(int $type)
    {
        $this->type = $type;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function toJSON()
    {
        return (object)[
            "type" => $this->type,
            "error" => $this->error
        ];

    }
}
