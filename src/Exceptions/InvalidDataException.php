<?php

namespace D4veR\Replicate\Exceptions;

class InvalidDataException extends \Exception
{
    public function __construct(
        string $message = 'Invalid data', 
        int $code = 0, 
        \Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}