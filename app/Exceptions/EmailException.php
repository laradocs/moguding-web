<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailException extends Exception
{
    public function __construct(string $message, int $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        parent::__construct($message, $code);

        $this->message = $message;
        $this->code = $code;
    }

    public function render(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->message,
                'errors' => [
                    'email' => [
                        $this->message,
                    ],
                ],
            ], $this->code);
        }

        return back()->withInput()
            ->withErrors(['email' => $this->message]);
    }
}
