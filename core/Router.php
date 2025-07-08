<?php

namespace Core;

/**
 * Router
 *
 * Handles HTTP route registration, dispatching, middleware, and controller action resolution.
 * Supports route groups, resourceful routes, closures, and dependency injection for controllers.
 *
 * @package Core
 */
class Router
{

    /**
     * Registered routes by HTTP method.
     * @var array
     */
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => []
    ];


    /**
     * Stack of group attributes for nested route groups.
     * @var array
     */
    protected $groupAttributes = [];

    /**
     * Handler for 404 Not Found responses.
     * @var callable|array|null
     */
    protected $notFoundHandler;


    /**
     * Load routes from a file and return a Router instance.
     *
     * @param string $file
     * @return static
     */
    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }


    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param mixed $controller
     * @return void
     */
    public function get($uri, $controller)
    {
        $this->addRoute('GET', $uri, $controller);
    }


    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param mixed $controller
     * @return void
     */
    public function post($uri, $controller)
    {
        $this->addRoute('POST', $uri, $controller);
    }


    /**
     * Register a PUT route.
     *
     * @param string $uri
     * @param mixed $controller
     * @return void
     */
    public function put($uri, $controller)
    {
        $this->addRoute('PUT', $uri, $controller);
    }


    /**
     * Register a PATCH route.
     *
     * @param string $uri
     * @param mixed $controller
     * @return void
     */
    public function patch($uri, $controller)
    {
        $this->addRoute('PATCH', $uri, $controller);
    }


    /**
     * Register a DELETE route.
     *
     * @param string $uri
     * @param mixed $controller
     * @return void
     */
    public function delete($uri, $controller)
    {
        $this->addRoute('DELETE', $uri, $controller);
    }


    /**
     * Group routes with shared attributes (e.g., middleware).
     *
     * @param array $attributes
     * @param callable $callback
     * @return void
     */
    public function group(array $attributes, callable $callback)
    {
        $this->groupAttributes[] = $attributes;
        $callback($this);
        array_pop($this->groupAttributes);
    }


    /**
     * Add a route to the internal routes array.
     *
     * @param string $method
     * @param string $uri
     * @param mixed $controller
     * @return void
     */
    protected function addRoute($method, $uri, $controller)
    {
        $attributes = array_merge([], ...$this->groupAttributes);
        $middleware = $attributes['middleware'] ?? [];

        $this->routes[$method][$uri] = [
            'controller' => $controller,
            'middleware' => (array) $middleware,
        ];
    }


    /**
     * Register a set of resourceful routes for a controller.
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */
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


    /**
     * Direct the request to the appropriate route handler.
     *
     * @param string $uri
     * @param string $requestType
     * @return mixed
     * @throws \Exception
     */
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


    /**
     * Set the handler for 404 Not Found responses.
     *
     * @param callable|array $handler
     * @return void
     */
    public function addNotFoundHandler($handler)
    {
        $this->notFoundHandler = $handler;
    }


    /**
     * Run all middleware for the current route.
     *
     * @param array $middlewares
     * @return void
     * @throws \Exception
     */
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


    /**
     * Call a controller action, optionally injecting dependencies and parameters.
     *
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
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
