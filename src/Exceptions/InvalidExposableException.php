<?php

namespace ArjanWestdorp\Exposable\Exceptions;

use Exception;

class InvalidExposableException extends Exception
{
    /**
     * Exposable not defined in configuration.
     *
     * @param string $class
     * @return InvalidExposableException
     */
    public static function exposableNotDefined($class)
    {
        return new static('Exposable not defined in config file for: '.$class);
    }
}
