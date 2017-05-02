<?php

namespace ArjanWestdorp\Exposable\Signers;

use Carbon\Carbon;

class ExposableSigner extends BaseSigner
{
    /**
     * Add expire parameter to the url.
     *
     * @param string $expiration
     * @return $this
     */
    public function expire($expiration)
    {
        if (is_null($expiration)) {
            return $this;
        }

        // By default we assume minutes
        if (is_int($expiration)) {
            $expiration .= ' minutes';
        }

        $timestamp = Carbon::now()->modify($expiration)->timestamp;

        return $this->add('expire', $timestamp);
    }

    /**
     * Add guard parameter to the url.
     *
     * @param string $value
     * @return $this
     */
    public function guard($value)
    {
        if (is_null($value)) {
            return $this;
        }

        return $this->add('guard', $value);
    }
}
