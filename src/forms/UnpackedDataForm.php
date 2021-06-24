<?php


namespace Cryptolib\CryptoCore\forms;


use Carbon\Carbon;
use DateTime;

class UnpackedDataForm
{

    protected $command;

    protected $entity;
    protected $subCommand;

    protected $datetime;
    protected $size;

    protected $payloadData;

    protected $checksum;

    protected $inputData;


    public function __construct(string $inputData)
    {
        $this->inputData = base64_decode($inputData);

        $this->payloadData = null;

        $this->command = unpack("n", $this->inputData, 0);

        $this->entity = ord($this->inputData[0]);
        $this->subCommand = ord($this->inputData[1]);

        $this->datetime = unpack("J", $this->inputData, 2);

        $this->size = unpack("N", $this->inputData, 10);

        switch ($this->command) {
            case 0:
                $this->payloadData = substr($this->inputData, 12, strlen($this->inputData) - 16);
                $this->checksum = unpack("N", $this->inputData, strlen($this->inputData) - 4);
                break;
            case 1:
                $this->payloadData = unpack("N", $this->inputData, 14);
                $this->checksum = unpack("N", $this->inputData, 18);
                break;
        }


    }

    public function isValid(): bool
    {
        return crc32($this->command . $this->datetime . $this->size . $this->payloadData) == $this->checksum;
    }

    /**
     * @return mixed
     */
    public function getCommand(): int
    {
        return $this->command;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @return mixed
     */
    public function getSize(): int
    {
        return $this->size;
    }


    /**
     * @return mixed
     */
    public function getChecksum(): int
    {
        return $this->checksum;
    }


    /**
     * @return String
     */
    public function getInputData(): string
    {
        return $this->inputData;
    }


    /**
     * @return array|false
     */
    public function getPayloadData(): string
    {
        return $this->payloadData;
    }


    public function toJSON()
    {
        return (object)[
            "command" => $this->command,
            "datetime" => $this->datetime,
            "size" => $this->size,
            "payloadData" => $this->payloadData,
            "checksum" => $this->checksum
        ];
    }

    public function toJSONString()
    {
        return json_encode($this->toJSON());
    }

}
