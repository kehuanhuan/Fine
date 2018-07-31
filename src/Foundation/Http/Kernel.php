<?php

namespace Kehuanhuan\Foundation\Http;

use Kehuanhuan\Routing\Router;
use Kehuanhuan\Contracts\Foundation\Application;
use Kehuanhuan\Contracts\Http\Kernel as KernelContract;

class Kernel implements KernelContract
{
    /**
     * The application implementation.
     *
     * @var \Kehuanhuan\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The router instance.
     *
     * @var \Kehuanhuan\Routing\Router
     */
    protected $router;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Kehuanhuan\Foundation\Bootstrap\RegisterFacades::class,
    ];

    /**
     * The application's middleware stack.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [];

    /**
     * The priority-sorted list of middleware.
     *
     * Forces the listed middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [];

    /**
     * Create a new HTTP kernel instance.
     *
     * @param  \Kehuanhuan\Contracts\Foundation\Application  $app
     * @param  \Kehuanhuan\Routing\Router  $router
     * @return void
     */
    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Kehuanhuan\Http\Request  $request
     * @return \Kehuanhuan\Http\Response
     */
    public function handle($request)
    {
         $this->bootstrap();
         $this->setRouter(); //注册路由

         return $this->router->dispatch($request);
    }

    //注册路由
    protected function setRouter()
    {
        # code...
    }

        /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        // if (! $this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        // }
    }

    /**
     * Get the bootstrap classes for the application.
     *
     * @return array
     */
    protected function bootstrappers()
    {
        return $this->bootstrappers;
    }

        /**
     * Perform any final actions for the request lifecycle.
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     * @return void
     */
    public function terminate($request, $response) {

    }

    /**
     * Get the Laravel application instance.
     *
     * @return \Kehuanhuan\Contracts\Foundation\Application
     */
    public function getApplication() {
         return $this->app;
    }
}