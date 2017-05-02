<?php

namespace ArjanWestdorp\Exposable\Exceptions;

use Exception;

class InvalidGuardException extends Exception
{
    /**
     * Guard not defined in configuration.
     *
     * @param string $key
     * @return InvalidGuardException
     */
    public static function guardNotDefined($key)
    {
        return new static('Guard not defined for: '.$key);
    }
}
