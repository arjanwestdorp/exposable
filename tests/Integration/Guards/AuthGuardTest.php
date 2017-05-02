<?php

namespace ArjanWestdorp\Exposable\Test\Integration\Guards;

use ArjanWestdorp\Exposable\Test\TestCase;
use ArjanWestdorp\Exposable\Test\Stubs\User;
use ArjanWestdorp\Exposable\Exceptions\UnauthorizedException;

class AuthGuardTest extends TestCase
{
    /** @test */
    public function it_authenticates_if_the_user_is_logged_in()
    {
        $this->be(factory(User::class)->create());

        $this->visit(url('/middleware-guard?guard=auth'))->assertResponseOk()->see('You did it');
    }

    /** @test */
    public function it_does_not_authenticate_if_the_user_is_not_logged_in()
    {
        $this->disableExceptionHandling()->expectException(UnauthorizedException::class);

        $this->visit(url('/middleware-guard?guard=auth'));
    }
}
