<?php

namespace BenBjurstrom\Replicate\Exceptions;

class TypeException extends \Exception
{
    public function __construct(
        string $message = 'Unexpected data type',
        int $code = 0, 
        \Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}