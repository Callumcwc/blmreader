<?php

namespace Renedekat\Blm\Exceptions;

use Exception;

class InvalidBlmFileException extends Exception
{

    /**
     * @param string $message Exception message to throw
     */
    public function __construct($message)
    {
        parent::__construct($message);

    }
}
