<?php

namespace ArjanWestdorp\Exposable\Test\Stubs;

use ArjanWestdorp\Exposable\Guards\Guard;

class FakeAuthenticatedGuard implements Guard
{
    /**
     * Authenticate the user based on the default Laravel implementation.
     *
     * @return bool
     */
    public function authenticate()
    {
        return true;
    }
}
