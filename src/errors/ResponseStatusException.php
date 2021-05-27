<?php

namespace Cryptolib\CryptoCore\Exceptions;

use Exception;
use Throwable;

class ResponseStatusException extends Exception
{

    protected $title;

    public function __construct($title, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->title = $title ?? '';
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function toJson()
    {
        return (object)[
            "title" => $this->title,
            "code" => $this->getCode(),
            "detail" => $this->getMessage()
        ];
    }
}
