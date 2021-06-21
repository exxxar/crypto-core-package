<?php


namespace Cryptolib\CryptoCore\forms;


class UnpackedUserDataForm
{

    protected $command;
    protected $datetime;
    protected $size;
    protected $pointId;
    protected $checksum;

    public function __construct(String $userData)
    {
        $this->command = unpack("n", $userData, 0);
        $this->datetime = unpack("J", $userData, 2);
        $this->size = unpack("N", $userData, 10);
        $this->pointId = unpack("N", $userData, 14);
        $this->checksum = unpack("N", $userData, 18);
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * @param mixed $checksum
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;
    }

    /**
     * @return array|false
     */
    public function getPointId()
    {
        return $this->pointId;
    }

    /**
     * @param array|false $pointId
     */
    public function setPointId($pointId)
    {
        $this->pointId = $pointId;
    }

    public function toJSON()
    {
        return (object)[
            "command" => $this->command,
            "datetime" => $this->datetime,
            "size" => $this->size,
            "pointId" => $this->pointId,
            "checksum" => $this->checksum
        ];
    }

    public function toJSONString()
    {
        return json_encode($this->toJSON());
    }

}
