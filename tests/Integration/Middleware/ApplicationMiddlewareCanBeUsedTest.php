<?php

namespace ArjanWestdorp\Exposable\Test\Integration\Middleware;

use ArjanWestdorp\Exposable\Test\Stubs\User;
use ArjanWestdorp\Exposable\Test\TestCase;
use Illuminate\Auth\AuthenticationException;

class ApplicationMiddlewareCanBeUsedTest extends TestCase
{
    /**
     * Add change the exposable.middleware before registering the package.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    public function getPackageProviders($app)
    {
        $app['config']->set('exposable.middleware', ['auth']);

        return parent::getPackageProviders($app);
    }

    /** @test */
    public function it_will_use_the_application_auth_middleware_and_fail_without_user()
    {
        $this->disableExceptionHandling()->useAuthenticatedGuard()->expectException(AuthenticationException::class);

        $this->get($this->createAttachment()->exposeUrl())->assertStatus(401);
    }

    /** @test */
    public function it_will_use_the_application_auth_middleware_and_succeed_with_a_user()
    {
        $this->be(factory(User::class)->create());

        $this->get($this->createAttachment()->exposeUrl())->assertStatus(200)->assertSee('You did it');
    }
}
