<?php

namespace ReneDeKat\Blm\Exceptions;

use Exception;

class InvalidBlmStringException extends Exception
{
    /**
     * @param string $message Exception message to throw
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
