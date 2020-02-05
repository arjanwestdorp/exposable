<?php

namespace ArjanWestdorp\Exposable\Test\Integration\Middleware;

use ArjanWestdorp\Exposable\Exceptions\InvalidGuardException;
use ArjanWestdorp\Exposable\Exceptions\UnauthorizedException;
use ArjanWestdorp\Exposable\Test\TestCase;

class AuthorizeTest extends TestCase
{
    /** @test */
    public function it_does_not_expose_when_no_guard_is_given_and_guard_is_configured_as_required()
    {
        $this->disableExceptionHandling()->expectException(UnauthorizedException::class);

        $this->get(url('/middleware-guard'));
    }

    /** @test */
    public function it_does_expose_when_no_guard_is_given_and_guard_is_configured_as_not_required()
    {
        $this->config('require-guard', false);

        $this->get(url('/middleware-guard'))->assertSee('You did it');
    }

    /** @test */
    public function it_throws_an_unauthorized_exception_when_guard_responds_with_unauthenticated()
    {
        $this->disableExceptionHandling()->expectException(UnauthorizedException::class);

        $this->get(url('/middleware-guard?guard=unauthenticated'));
    }

    /** @test */
    public function it_succeeds_when_guard_is_authenticated()
    {
        $this->get(url('/middleware-guard?guard=authenticated'))->assertSee('You did it');
    }

    /** @test */
    public function it_throws_an_exception_if_the_guard_is_not_defined()
    {
        $this->disableExceptionHandling()->expectException(InvalidGuardException::class);

        $this->get(url('/middleware-guard?guard=undefined'));
    }
}
