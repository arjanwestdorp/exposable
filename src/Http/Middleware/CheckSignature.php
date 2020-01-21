<?php

namespace ArjanWestdorp\Exposable\Http\Middleware;

use ArjanWestdorp\Exposable\Exceptions\InvalidSignatureException;
use ArjanWestdorp\Exposable\Signers\Signer;
use Closure;
use Illuminate\Http\Request;

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
