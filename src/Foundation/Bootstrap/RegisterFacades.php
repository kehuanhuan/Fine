<?php

namespace Kehuanhuan\Foundation\Bootstrap;

use Kehuanhuan\Support\Facades\Facade;
use Kehuanhuan\Contracts\Foundation\Application;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Kehuanhuan\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);
    }
}
