<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class NoPermissionException extends Exception
{
    public function __construct ( string $message = '权限不足。', int $code = 403 )
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
