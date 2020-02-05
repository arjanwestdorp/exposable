<?php

namespace ArjanWestdorp\Exposable\Test\Unit\Traits;

use ArjanWestdorp\Exposable\Exceptions\InvalidExposableException;
use ArjanWestdorp\Exposable\Exceptions\InvalidGuardException;
use ArjanWestdorp\Exposable\Test\TestCase;
use Carbon\Carbon;

class ExposableTest extends TestCase
{
    /** @test */
    public function it_will_use_the_config_file_values_by_default_when_generating_an_expose_url()
    {
        $this->setUpDefaultConfiguration();

        $url = $this->createAttachment()->exposeUrl();

        $this->assertContains('expire='.Carbon::now()->addMinutes(config('exposable.lifetime'))->timestamp, $url);
        $this->assertContains('guard='.config('exposable.default-guard'), $url);
    }

    /**
     * Setup default configuration.
     */
    protected function setUpDefaultConfiguration()
    {
        $this->config('default-guard', 'authenticated');
        $this->config('expire', 5);
    }

    /** @test */
    public function the_exposable_guard_can_be_set_on_a_model()
    {
        $this->setUpDefaultConfiguration();

        $url = $this->createAttachment()->setExposableGuard('unauthenticated')->exposeUrl();

        $this->assertContains('guard=unauthenticated', $url);
    }

    /** @test */
    public function it_will_throw_an_exception_if_the_guard_is_not_defined_when_setting_it()
    {
        $this->disableExceptionHandling()->expectException(InvalidGuardException::class);

        $this->createAttachment()->setExposableGuard('invalidguard');
    }

    /** @test */
    public function the_exposable_expire_can_be_set_on_a_model()
    {
        $url = $this->createAttachment()->setExposableLifetime('1 days')->exposeUrl();

        $this->assertContains('expire='.Carbon::now()->addDay()->timestamp, $url);
    }

    /** @test */
    public function it_can_generate_an_expose_url_for_an_exposable_model()
    {
        $attachment = $this->createAttachment();

        $url = $attachment->exposeUrl();

        $this->assertTrue(starts_with($url, route('exposable.show', [
            $attachment->getExposableKey(),
            $attachment->id,
        ])));
    }

    /** @test */
    public function it_will_throw_an_error_when_the_model_uses_the_exposable_trait_but_is_not_in_the_exposable_config_array()
    {
        $this->disableExceptionHandling()->expectException(InvalidExposableException::class);

        $this->config('exposables.attachment-key', 'invalid');

        $attachment = $this->createAttachment();

        $attachment->exposeUrl();
    }
}
