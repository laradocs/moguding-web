<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class RecordNotFoundException extends Exception
{
    public function __construct ( string $message = '该记录不存在。', int $code = 404 )
    {
        parent::__construct ( $message, $code );
    }

    public function render ( Request $request )
    {
        if ( $request->expectsJson() ) {
            return response()->json ( [
                'message' => $this->message,
            ], $this->code );
        }

        abort ( $this->code );
    }
}
