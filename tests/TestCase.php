<?php

namespace ArjanWestdorp\Exposable\Test;

use ArjanWestdorp\Exposable\ExposableServiceProvider;
use ArjanWestdorp\Exposable\Test\Stubs\Attachment;
use ArjanWestdorp\Exposable\Test\Stubs\FakeAuthenticatedGuard;
use ArjanWestdorp\Exposable\Test\Stubs\FakeUnauthenticatedGuard;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Orchestra\Database\ConsoleServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        // Load migrations
        $this->loadMigrations();

        // Load the factories.
        $this->withFactories(__DIR__.'/factories');

        Carbon::setTestNow(Carbon::create(2017, 1, 1, 9, 0, 0));

        $this->setUpRoutes();

        // Register the test guards
        $this->config('guards', array_merge(config('exposable.guards'), [
            'unauthenticated' => FakeUnauthenticatedGuard::class,
            'authenticated' => FakeAuthenticatedGuard::class,
        ]));

        // Register the testing model.
        $this->config('exposables', [
            'attachment-key' => Attachment::class,
        ]);
    }

    /**
     * Load the migrations.
     * This will load the laravel migrations and the migrations for testing.
     */
    protected function loadMigrations()
    {
        $this->loadLaravelMigrations(['--database' => 'testbench']);

        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);
    }

    /**
     * Setup the routes that are only for testing.
     * Mainly used for testing middleware.
     */
    protected function setUpRoutes()
    {
        $this->app['router']->get('/middleware-guard', function () {
            return 'You did it';
        })->middleware('exposable.guard');

        $this->app['router']->get('/middleware-expire', function () {
            return 'You did it';
        })->middleware('exposable.expire');

        $this->app['router']->get('/middleware-signature', function () {
            return 'You did it';
        })->middleware('exposable.signature');
    }

    /**
     * Set the exposable config value for the given key.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function config($key, $value)
    {
        $this->app['config']->set('exposable.'.$key, $value);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class,
            ExposableServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Set a fake app key
        $app['config']->set('app.key', 'base64:uynE8re8ybt2wabaBjqMwQvLczKlDSQJHCepqxmGffE=');
    }

    /**
     * Disable exception handling.
     *
     * @return $this
     */
    protected function disableExceptionHandling()
    {
        app()->instance(ExceptionHandler::class, new PassThroughHandler);

        return $this;
    }

    /**
     * Create an attachment to test with.
     *
     * @return Attachment
     */
    protected function createAttachment()
    {
        return factory(Attachment::class)->create();
    }

    /**
     * Set the guard to authenticate with success.
     *
     * @return $this
     */
    protected function useAuthenticatedGuard()
    {
        $this->config('default-guard', 'authenticated');

        return $this;
    }

    /**
     * Set the guard to authenticate with failure.
     *
     * @return $this
     */
    protected function useUnauthenticatedGuard()
    {
        $this->config('default-guard', 'unauthenticated');

        return $this;
    }
}

class PassThroughHandler extends Handler
{
    public function __construct()
    {
        parent::__construct(app());
    }

    public function report(Exception $e)
    {
        // no-op
    }

    public function render($request, Exception $e)
    {
        throw $e;
    }
}
