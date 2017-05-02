<?php

namespace ArjanWestdorp\Exposable\Signers;

use Illuminate\Support\Facades\Facade;

/**
 * Class Signer.
 *
 * @method static ExposableSigner url($url)
 * @method static bool validate($url)
 */
class Signer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'exposable.signer';
    }
}
