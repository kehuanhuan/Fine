<?php

namespace Kehuanhuan;

class HandleError
{
    public function __construct()
    {
        set_exception_handler([$this, 'handler']);
    }

    public function handler($exception)
    {
        echo get_class($exception);
        echo "\n";
        echo $exception->getFile();
        echo "\n";
        echo $exception->getLine();
        echo "\n";
        echo $exception->getMessage();
        echo "\n";
    }
}