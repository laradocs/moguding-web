<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);

        $this->message = $message;
        $this->code = $code;
    }

    public function render()
    {
        abort($this->code, $this->message);
    }
}
