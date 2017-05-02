<?php

namespace ArjanWestdorp\Exposable\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ArjanWestdorp\Exposable\Exceptions\ExpiredExposableException;

class CheckExpiration
{
    /**
     * Check if the url is not expired.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ExpiredExposableException
     */
    public function handle($request, Closure $next)
    {
        if (! $request->has('expire')) {
            throw ExpiredExposableException::noExpireGiven();
        }

        if ($this->isExpired($request->get('expire'))) {
            throw ExpiredExposableException::exposableExpired();
        }

        return $next($request);
    }

    /**
     * Check if the given timestamp is expired.
     *
     * @param int $expire
     * @return bool
     */
    protected function isExpired($expire)
    {
        $date = Carbon::createFromTimestamp((int) $expire);

        return $date->isPast();
    }
}
