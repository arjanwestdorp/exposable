<?php

namespace ArjanWestdorp\Exposable\Exceptions;

use Exception;

class ExpiredExposableException extends Exception
{
    /**
     * Exposable url expired.
     *
     * @return ExpiredExposableException
     */
    public static function exposableExpired()
    {
        return new static('Exposable is expired');
    }

    /**
     * Expire date is not set.
     *
     * @return static
     */
    public static function noExpireGiven()
    {
        return new static('Expire is not set.');
    }
}
