<?php

namespace ArjanWestdorp\Exposable\Test\Stubs;

use ArjanWestdorp\Exposable\Guards\Guard;

class FakeUnauthenticatedGuard implements Guard
{
    /**
     * Authenticate the user based on the default Laravel implementation.
     *
     * @return bool
     */
    public function authenticate()
    {
        return false;
    }
}
