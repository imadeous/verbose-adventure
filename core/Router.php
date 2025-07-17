<?php

namespace Core;

/**
 * Router class for registering and dispatching routes.
 * Normalizes URIs, handles base paths, and provides clear errors.

 */
class Router
{
    protected $currentMiddleware = [];
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];
    public $routeMiddleware = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Register standard RESTful resource routes for a controller.
     * Example: $router->resource('/admin/users', UserController::class);
     *
     * GET    /resource              => index
     * GET    /resource/create       => create
     * POST   /resource              => store
     * GET    /resource/{id}         => show
     * GET    /resource/{id}/edit    => edit
     * POST   /resource/{id}         => update
     * POST   /resource/{id}/delete  => destroy
     */
    public function resource($base, $controller)
    {
        $base = $this->normalize($base);
        // Always use 'id' as the route key
        $this->get($base, [$controller, 'index']);
        $this->get($base . '/create', [$controller, 'create']);
        $this->post($base, [$controller, 'store']);
        $this->get($base . '/{id}', [$controller, 'show']);
        $this->get($base . '/{id}/edit', [$controller, 'edit']);
        $this->post($base . '/{id}', [$controller, 'update']);
        $this->post($base . '/{id}/delete', [$controller, 'destroy']);
        return new ResourceRouteGroup($this, $base, $controller, 'id');
    }

    /**
     * Register a GET route.
     */

    /**
     * Register a GET route. Accepts string (Controller@method) or array callable.
     */
    public function get($uri, $handler)
    {
        $uri = $this->normalize($uri);
        $this->routes['GET'][$uri] = $handler;
        if (!empty($this->currentMiddleware)) {
            $this->routeMiddleware['GET'][$uri] = $this->currentMiddleware;
        }
    }

    /**
     * Register a POST route.
     */

    /**
     * Register a POST route. Accepts string (Controller@method) or array callable.
     */
    public function post($uri, $handler)
    {
        $uri = $this->normalize($uri);
        $this->routes['POST'][$uri] = $handler;
        if (!empty($this->currentMiddleware)) {
            $this->routeMiddleware['POST'][$uri] = $this->currentMiddleware;
        }
    }
    /**
     * Apply middleware to a group of routes.
     * Usage: $router->middleware([AuthMiddleware::class], function($router) { ... });
     */
    public function middleware(array $middleware, callable $callback)
    {
        $previous = $this->currentMiddleware;
        $this->currentMiddleware = array_merge($this->currentMiddleware, $middleware);
        $callback($this);
        $this->currentMiddleware = $previous;
    }

    /**
     * Direct the request to the appropriate controller/action.
     */

    public function direct($uri, $method)
    {
        $uri = $this->normalize($uri);
        // Exact match first
        if (isset($this->routes[$method][$uri])) {
            $routeKey = $uri;
        } else {
            // Dynamic match: replace {param} with regex ([^/]+)
            $routeKey = null;
            foreach ($this->routes[$method] as $routePattern => $handler) {
                $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $routePattern);
                $pattern = '#^' . $pattern . '$#';
                if (preg_match($pattern, $uri, $matches)) {
                    $routeKey = $routePattern;
                    // Extract params
                    array_shift($matches); // Remove full match
                    $params = $matches;
                    break;
                }
            }
            if (!$routeKey) {
                // Use custom 404 controller
                if (class_exists('App\\Controllers\\App\\ErrorController')) {
                    (new \App\Controllers\App\ErrorController())->notFound();
                } else {
                    http_response_code(404);
                    echo "<h1>404 Not Found</h1><p>No route defined for <code>{$uri}</code> [{$method}]</p>";
                    exit;
                }
            }
        }
        // Run middleware for this route if any
        if (!empty($this->routeMiddleware[$method][$routeKey])) {
            foreach ($this->routeMiddleware[$method][$routeKey] as $middlewareClass) {
                if (class_exists($middlewareClass) && method_exists($middlewareClass, 'handle')) {
                    $middlewareClass::handle();
                }
            }
        }
        $handler = $this->routes[$method][$routeKey];
        // If handler is array callable: [ControllerClass::class, 'method']
        if (is_array($handler) && count($handler) === 2 && is_string($handler[0]) && is_string($handler[1])) {
            $controllerClass = $handler[0];
            $action = $handler[1];
            if (!class_exists($controllerClass)) {
                http_response_code(500);
                echo "<h1>500 Internal Server Error</h1><p>Controller <code>{$controllerClass}</code> not found.</p>";
                exit;
            }
            $controllerInstance = new $controllerClass;
            if (!method_exists($controllerInstance, $action)) {
                http_response_code(500);
                echo "<h1>500 Internal Server Error</h1><p>Action <code>{$action}</code> not found in controller <code>{$controllerClass}</code>.</p>";
                exit;
            }
            return isset($params) ? $controllerInstance->$action(...$params) : $controllerInstance->$action();
        }
        // If handler is string: 'Controller@method' (legacy)
        if (is_string($handler) && strpos($handler, '@') !== false) {
            return $this->callAction(...explode('@', $handler));
        }
        // If handler is a closure or other callable
        if (is_callable($handler)) {
            return call_user_func($handler);
        }
        http_response_code(500);
        echo "<h1>500 Internal Server Error</h1><p>Invalid route handler for <code>{$uri}</code> [{$method}]</p>";
        exit;
    }

    /**
     * Normalize a URI (remove trailing slashes, ensure leading slash).
     */
    public function normalize($uri)
    {
        $uri = '/' . ltrim($uri, '/');
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }
        return $uri;
    }

    /**
     * Call the controller action.
     */
    protected function callAction($controller, $action)
    {
        $controllerClass = "App\\Controllers\\{$controller}";
        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "<h1>500 Internal Server Error</h1><p>Controller <code>{$controllerClass}</code> not found.</p>";
            exit;
        }
        $controllerInstance = new $controllerClass;
        if (!method_exists($controllerInstance, $action)) {
            http_response_code(500);
            echo "<h1>500 Internal Server Error</h1><p>Action <code>{$action}</code> not found in controller <code>{$controllerClass}</code>.</p>";
            exit;
        }
        return $controllerInstance->$action();
    }
}

// Helper class for resource route chaining
class ResourceRouteGroup
{
    protected $router;
    protected $base;
    protected $controller;
    protected $routeKey;
    protected $actionUris = [];
    protected $actionMethods = [
        'index'   => 'GET',
        'create'  => 'GET',
        'store'   => 'POST',
        'show'    => 'GET',
        'edit'    => 'GET',
        'update'  => 'POST',
        'destroy' => 'POST',
    ];
    public function __construct($router, $base, $controller, $routeKey = 'id')
    {
        $this->router = $router;
        $this->base = $base;
        $this->controller = $controller;
        $this->routeKey = $routeKey;
        $rk = $this->routeKey;
        $this->actionUris = [
            'index'   => '',
            'create'  => '/create',
            'store'   => '',
            'show'    => '/{' . $rk . '}',
            'edit'    => '/{' . $rk . '}/edit',
            'update'  => '/{' . $rk . '}',
            'destroy' => '/{' . $rk . '}/delete',
        ];
    }
    // $middleware: class name, $actions: array of action names
    public function middleware($middleware, array $actions)
    {
        foreach ($actions as $action) {
            $action = strtolower($action);
            if (!isset($this->actionUris[$action])) continue;
            $uri = $this->base . $this->actionUris[$action];
            $method = $this->actionMethods[$action];
            $uri = $this->router->normalize($uri);
            if (!isset($this->router->routeMiddleware[$method][$uri])) {
                $this->router->routeMiddleware[$method][$uri] = [];
            }
            $this->router->routeMiddleware[$method][$uri][] = $middleware;
        }
        return $this;
    }
}
