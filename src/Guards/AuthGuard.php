<?php

namespace ArjanWestdorp\Exposable\Guards;

class AuthGuard implements Guard
{
    /**
     * Check if the user is authenticated.
     *
     * @return bool
     */
    public function authenticate()
    {
        return auth()->check();
    }
}
