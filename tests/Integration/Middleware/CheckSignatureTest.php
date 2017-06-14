<?php

namespace ArjanWestdorp\Exposable\Test\Integration\Middleware;

use ArjanWestdorp\Exposable\Test\TestCase;
use ArjanWestdorp\Exposable\Signers\Signer;
use ArjanWestdorp\Exposable\Exceptions\InvalidSignatureException;

class CheckSignatureTest extends TestCase
{
    /** @test */
    public function it_will_throw_an_exception_if_the_signature_does_not_match_with_the_url()
    {
        $this->disableExceptionHandling()->expectException(InvalidSignatureException::class);

        $url = $this->getSignedUrl();
        $url = str_replace('signature=', 'signature=x', $url);

        $this->get($url);
    }

    /**
     * Get a signed url to test.
     *
     * @param string|null $url
     * @return string
     */
    protected function getSignedUrl($url = null)
    {
        return Signer::url($url ?: url('/middleware-signature'))->sign();
    }

    /** @test */
    public function it_will_throw_an_exception_if_no_signature_is_given()
    {
        $this->disableExceptionHandling()->expectException(InvalidSignatureException::class);

        $this->get(url('/middleware-signature'));
    }

    /** @test */
    public function it_will_throw_an_exception_if_there_is_tampered_with_the_url()
    {
        $this->disableExceptionHandling()->expectException(InvalidSignatureException::class);

        $url = $this->getSignedUrl(url('/middleware-signature?expire=5'));
        $url = str_replace('expire=5', 'expire=never', $url);

        $this->get($url);
    }

    /** @test */
    public function it_will_succeed_if_the_signature_matches_the_url()
    {
        $this->get($this->getSignedUrl())->assertSuccessful()->assertSee('You did it');
    }
}
