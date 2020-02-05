<?php

namespace ArjanWestdorp\Exposable\Test\Integration\Guards;

use ArjanWestdorp\Exposable\Exceptions\UnauthorizedException;
use ArjanWestdorp\Exposable\Test\Stubs\User;
use ArjanWestdorp\Exposable\Test\TestCase;

class AuthGuardTest extends TestCase
{
    /** @test */
    public function it_authenticates_if_the_user_is_logged_in()
    {
        $this->be(factory(User::class)->create());

        $this->get(url('/middleware-guard?guard=auth'))
            ->assertSuccessful()
            ->assertSee('You did it');
    }

    /** @test */
    public function it_does_not_authenticate_if_the_user_is_not_logged_in()
    {
        $this->disableExceptionHandling()->expectException(UnauthorizedException::class);

        $this->get(url('/middleware-guard?guard=auth'));
    }
}
