<?php

namespace ArjanWestdorp\Exposable\Exceptions;

use Exception;

class InvalidSignatureException extends Exception
{
    /**
     * Signature is invalid for the given url.
     *
     * @return InvalidSignatureException
     */
    public static function invalidSignature()
    {
        return new static('Invalid signature.');
    }

    /**
     * Signature is not available in the url.
     *
     * @return InvalidSignatureException
     */
    public static function noSignature()
    {
        return new static('Url is not signed.');
    }
}
