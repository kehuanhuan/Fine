<?php

namespace Kehuanhuan\Http;

/**
*  请求
*/
class Request
{

     public $uri;
     public $method;

    public function __construct()
    {
        $this->uri = preg_replace('/\/+/', '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function uri()
    {
        return $this->uri;
    }

    public function method()
    {
        return $this->method;
    }
}