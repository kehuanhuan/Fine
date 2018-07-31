<?php

namespace Kehuanhuan\Foundation\Console;

use Kehuanhuan\Exceptions\ArtisanCommandNotfoundException;
use Kehuanhuan\Contracts\Foundation\Application;

class Kernel
{

    public static $callbacks = [];
    public static $commands = [];

    protected $app;

    protected $bootstrappers = [
        \Kehuanhuan\Foundation\Bootstrap\RegisterFacades::class,
    ];


    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Defines a route w/ callback and method
     */
    public function command($command, $method) {

        self::$commands[] = $command;
        self::$callbacks[$command] = $method;
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {

    }

    public function handle(){

        $this->bootstrap();

        $this->commands();

        $args = $_SERVER['argv'];

        if(!isset($args[1])){
            var_export(self::$commands);
            return ;
        }

        if (isset(self::$callbacks[$args[1]])) {
            call_user_func(self::$callbacks[$args[1]]);
        } else {
            throw new ArtisanCommandNotfoundException("没有这个命令");
        }

    }


    public function bootstrap()
    {
        $this->app->bootstrapWith($this->bootstrappers());
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
}