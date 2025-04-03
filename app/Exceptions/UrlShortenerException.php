<?php

// app/Exceptions/UrlShortenerException.php
namespace App\Exceptions;

use Exception;

class UrlShortenerException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->getCode() ?: 400);
    }
}
