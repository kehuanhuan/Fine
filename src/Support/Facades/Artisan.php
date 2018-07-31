<?php

namespace Kehuanhuan\Support\Facades;

use Kehuanhuan\Contracts\Console\Kernel as ConsoleKernelContract;

/**
 * @see \Kehuanhuan\Contracts\Console\Kernel
 */
class Artisan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ConsoleKernelContract::class;
    }
}
