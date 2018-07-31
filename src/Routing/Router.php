<?php

namespace Kehuanhuan\Routing;

use Kehuanhuan\Http\Request;

class Router {

    protected static $routes = [];
    protected static $methods = [];
    protected static $callbacks = [];

    public function get($uri, $callback)
    {
        $this->addRouter('GET', $uri, $callback);
    }

    protected function addRouter($method, $uri, $callback)
    {
        array_push(self::$routes, $uri);
        self::$methods[$uri] = $method;
        self::$callbacks[$uri] = $callback;
    }

    /**
     * Runs the callback f or the given request
     */
    public function dispatch(Request $request) {

        $uri = $request->uri();
        $method = $request->method();

        if (in_array($uri, self::$routes)) {
            if (self::$methods[$uri] == $method || self::$methods[$uri] == 'ANY') {
                if (is_object(self::$callbacks[$uri])) {
                     call_user_func(self::$callbacks[$uri]);
                } else {
                    $s = explode('@', self::$callbacks[$uri]);
                    call_user_func(array((new $s[0]), $s[1]));
                }
            }
        } else {
            header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
            echo '404';
        }
    }
}