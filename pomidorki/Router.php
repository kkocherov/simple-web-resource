<?php

namespace pomidorki;

class NotFoundException extends \Exception {};

class Router {
    private $routes = [];

    function addRoute($predicate, $handler) {
        $this->routes[] = [$predicate, $handler];
    }

    /**
     * @param $uri
     * @return mixed
     * @throws NotFoundException
     */
    function handleRequest($uri) {
        foreach ($this->routes as $route) {
            $predicate = $route[0];
            $handle = $route[1];
            if ($predicate($uri)) {
                return $handle($uri);
            }

        }

        throw new NotFoundException();
    }
}