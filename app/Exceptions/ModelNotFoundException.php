<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class ModelNotFoundException extends Exception
{
    public function __construct ( string $message, int $code = 404 )
    {
        parent::__construct ( $message, $code );
    }

    public function render()
    {
        return response()->json ( [
            'message' => $this->message,
        ], $this->code );
    }
}
