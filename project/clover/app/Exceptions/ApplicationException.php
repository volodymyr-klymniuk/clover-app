<?php

namespace App\Exceptions;

class ApplicationException extends \Exception
{
    public function getStatusCode()
    {
        return $this->getCode();
    }
}
