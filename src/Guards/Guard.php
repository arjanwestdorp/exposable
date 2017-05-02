<?php

namespace ArjanWestdorp\Exposable\Guards;

interface Guard
{
    /**
     * Check if the object can be exposed to the user.
     *
     * @return bool
     */
    public function authenticate();
}
