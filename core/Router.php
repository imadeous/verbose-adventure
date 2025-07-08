<?php

namespace Core;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];

    protected $groupAttributes = [];

    protected $notFoundHandler;

    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function get($uri, $controller)
    {
        $this->addRoute('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->addRoute('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->addRoute('PUT', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        $this->addRoute('PATCH', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->addRoute('DELETE', $uri, $controller);
    }

    public function group(array $attributes, callable $callback)
    {
        $this->groupAttributes[] = $attributes;
        $callback($this);
        array_pop($this->groupAttributes);
    }

    protected function addRoute($method, $uri, $controller)
    {
        $attributes = array_merge([], ...$this->groupAttributes);
        $middleware = $attributes['middleware'] ?? [];

        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'middleware' => (array) $middleware,
        ];
    }

    public function resource($uri, $controller)
    {
        $singular = rtrim($uri, 's'); // a simple way to get a singular version

        $this->get($uri, "{$controller}@index");
        $this->get("{$uri}/create", "{$controller}@create");
        $this->post($uri, "{$controller}@store");
        $this->get("{$uri}/{{$singular}}", "{$controller}@show");
        $this->get("{$uri}/{{$singular}}/edit", "{$controller}@edit");
        $this->put("{$uri}/{{$singular}}", "{$controller}@update");
        $this->patch("{$uri}/{{$singular}}", "{$controller}@update");
        $this->delete("{$uri}/{{$singular}}", "{$controller}@destroy");
    }

    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            $handler = $this->routes[$requestType][$uri];

            $this->runMiddleware($handler['middleware']);

            $controller = $handler['controller'];

            if ($controller instanceof \Closure) {
                return $controller();
            }

            if (is_array($controller)) {
                return $this->callAction(...$controller);
            }

            return $this->callAction(...explode('@', $controller));
        }

        // Handle route parameters
        foreach ($this->routes[$requestType] as $route => $handler) {
            $pattern = preg_replace('#\\{[a-zA-Z0-9_]+\\}#', '([a-zA-Z0-9_]+)', $route);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches);

                $this->runMiddleware($handler['middleware']);

                $controller = $handler['controller'];

                if ($controller instanceof \Closure) {
                    return call_user_func_array($controller, $matches);
                }

                if (is_array($controller)) {
                    return $this->callAction($controller[0], $controller[1], $matches);
                }

                $parts = explode('@', $controller);
                return $this->callAction($parts[0], $parts[1], $matches);
            }
        }

        if ($this->notFoundHandler) {
            $handler = $this->notFoundHandler;

            if (is_array($handler) && is_string($handler[0]) && class_exists($handler[0])) {
                // It's a [Controller::class, 'method'] pair, use callAction
                return $this->callAction(...$handler);
            }

            // Otherwise, assume it's a callable closure and execute it
            return call_user_func($handler);
        }

        throw new \Exception('No route defined for this URI.');
    }

    public function addNotFoundHandler($handler)
    {
        $this->notFoundHandler = $handler;
    }

    protected function runMiddleware(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            list($name, $param) = array_pad(explode(':', $middleware, 2), 2, null);

            $middlewareClass = "App\\Middleware\\" . ucfirst($name) . "Middleware";

            if (class_exists($middlewareClass)) {
                $instance = new $middlewareClass($param);
                $instance->handle();
            } else {
                throw new \Exception("Middleware {$middlewareClass} not found.");
            }
        }
    }

    protected function callAction($controller, $action, $params = [])
    {
        if (strpos($controller, 'App\\Controllers\\') !== 0) {
            $controller = "App\\Controllers\\{$controller}";
        }

        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        // Use reflection to inspect the method parameters
        $reflectionMethod = new \ReflectionMethod($controller, $action);
        $methodParams = $reflectionMethod->getParameters();

        $args = [];

        foreach ($methodParams as $param) {
            $paramType = $param->getType();
            if ($paramType && !$paramType->isBuiltin()) {
                $className = $paramType->getName();
                if ($className === 'Core\Request') {
                    // This is where we "inject" the Request object.
                    $args[] = new \Core\Request();
                    continue;
                }
            }
        }

        // Append the URL parameters
        $args = array_merge($args, $params);

        return $controller->$action(...$args);
    }
}
