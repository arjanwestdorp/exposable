<?php

namespace ArjanWestdorp\Exposable\Traits;

use ArjanWestdorp\Exposable\Signers\Signer;
use ArjanWestdorp\Exposable\Exceptions\InvalidGuardException;
use ArjanWestdorp\Exposable\Exceptions\InvalidExposableException;

trait Exposable
{
    /**
     * The guard to use when exposing this model.
     * This will override the default.
     *
     * @var string|null
     */
    protected $exposableGuard = null;

    /**
     * Time before the expose url expires in minutes or as date modification.
     * This will override the default.
     *
     * @var int|string|null
     */
    protected $exposableLifetime = null;

    /**
     * Expose the model.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function expose();

    /**
     * Return the url on which we expose the model.
     *
     * @return string
     */
    public function exposeUrl()
    {
        return Signer::url(route('exposable.show', [
            $this->getExposableKey(),
            $this->getKey(),
        ]))->guard($this->getExposableGuard())->expire($this->getExposableLifetime())->sign();
    }

    /**
     * Get the key to use when exposing this model.
     * This will be retrieved from the config.
     *
     * @return string
     * @throws InvalidExposableException
     */
    public function getExposableKey()
    {
        $exposables = collect(config('exposable.exposables'))->flip();

        if (! $exposables->has(self::class)) {
            throw InvalidExposableException::exposableNotDefined(static::class);
        }

        return $exposables->get(self::class);
    }

    /**
     * Get the exposable guard for this model.
     *
     * @return string|null
     */
    protected function getExposableGuard()
    {
        return $this->exposableGuard ?: config('exposable.default-guard');
    }

    /**
     * Set the exposable guard of the model.
     *
     * @param string $guard
     * @return $this
     * @throws InvalidGuardException
     */
    public function setExposableGuard($guard)
    {
        if (! config()->has('exposable.guards.'.$guard)) {
            throw InvalidGuardException::guardNotDefined($guard);
        }

        $this->exposableGuard = $guard;

        return $this;
    }

    /**
     * Get the exposable lifetime for this model.
     *
     * @return mixed
     */
    protected function getExposableLifetime()
    {
        return $this->exposableLifetime ?: config('exposable.lifetime');
    }

    /**
     * Set the exposable expire time in minutes.
     *
     * @param int $expire
     * @return $this
     */
    public function setExposableLifetime($expire)
    {
        $this->exposableLifetime = $expire;

        return $this;
    }
}
