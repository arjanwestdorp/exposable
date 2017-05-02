<?php

namespace ArjanWestdorp\Exposable\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ArjanWestdorp\Exposable\Signers\Signer;
use ArjanWestdorp\Exposable\Exceptions\InvalidSignatureException;

class CheckSignature
{
    /**
     * Check if the signature matches is valid.
     * This is to protect people tampering with the url.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidSignatureException
     */
    public function handle($request, Closure $next)
    {
        if (! $request->has('signature')) {
            throw InvalidSignatureException::noSignature();
        }

        if (! Signer::validate($request->fullUrl())) {
            throw InvalidSignatureException::invalidSignature();
        }

        return $next($request);
    }
}
