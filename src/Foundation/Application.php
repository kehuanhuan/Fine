<?php

namespace Kehuanhuan\Foundation;

use Kehuanhuan\Container\Container;
use Kehuanhuan\Routing\RoutingServiceProvider;
use Kehuanhuan\Support\ServiceProvider;
use Kehuanhuan\Support\Arr;
use Kehuanhuan\Contracts\Foundation\Application as ApplicationContract;

class Application extends Container implements ApplicationContract
{

    /**
     * The Laravel framework version.
     *
     * @var string
     */
    const VERSION = '0.1.1';

    protected $basePath;

    /**
     * All of the registered service providers.
     *
     * @var array
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * Indicates if the application has "booted".
     *
     * @var bool
     */
    protected $booted = false;

    public function __construct($basePath = null)
    {
        $this->basePath = $basePath;

        $this->registerBaseBindings();

        $this->registerBaseServiceProviders();

    }

    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance(ApplicationContract::class, $this);
    }

    protected function registerBaseServiceProviders()
    {
        $this->register(new RoutingServiceProvider($this));
    }

    public function bootstrapWith(array $bootstrappers)
    {
        foreach ($bootstrappers as $bootstrapper) {
            $this->make($bootstrapper)->bootstrap($this);
        }
    }

    public function make($abstract, array $parameters = [])
    {
        return parent::make($abstract, $parameters);
    }

    public function register($provider, $options = [], $force = false)
    {
        if (($registered = $this->getProvider($provider)) && ! $force) {
            return $registered;
        }
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        if (method_exists($provider, 'register')) {
            $provider->register();
        }

        $this->markAsRegistered($provider);

        if ($this->booted) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    public function getProvider($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::first($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    /**
     * Boot the given service provider.
     *
     * @param  \Kehuanhuan\Support\ServiceProvider  $provider
     * @return mixed
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }

    /**
     * Mark the given provider as registered.
     *
     * @param  \Kehuanhuan\Support\ServiceProvider  $provider
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;

        $this->loadedProviders[get_class($provider)] = true;
    }

        /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version() {}

    /**
     * Get the base path of the Laravel installation.
     *
     * @return string
     */
    public function basePath() {}

    /**
     * Get or check the current application environment.
     *
     * @return string
     */
    public function environment() {}

    /**
     * Determine if we are running in the console.
     *
     * @return bool
     */
    public function runningInConsole() {}

    /**
     * Determine if the application is currently down for maintenance.
     *
     * @return bool
     */
    public function isDownForMaintenance() {}

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders() {}
    /**
     * Register a deferred provider and service.
     *
     * @param  string  $provider
     * @param  string|null  $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null) {}

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register a new boot listener.
     *
     * @param  mixed  $callback
     * @return void
     */
    public function booting($callback) {}

    /**
     * Register a new "booted" listener.
     *
     * @param  mixed  $callback
     * @return void
     */
    public function booted($callback) {}

    /**
     * Get the path to the cached services.php file.
     *
     * @return string
     */
    public function getCachedServicesPath() {}

    /**
     * Get the path to the cached packages.php file.
     *
     * @return string
     */
    public function getCachedPackagesPath() {}
}