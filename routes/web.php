
<?php

/**
 * Route file imports controller classes for handling various application routes.
 * This file is part of the web routing system.
 * It uses the Core Router class to define GET routes for different controllers.
 * The routes are defined using the `get` method of the Router class.  
 * The controllers handle the logic for rendering views and managing application state.
 * The routes are registered in the `routes/web.php` file.  
 * The controllers are namespaced under `App\Controllers\Admin` and `App\Controllers\App`.
 * The HomeController handles the main application logic, while the AdminController manages admin-specific routes.
 */

// Import necessary controller classes
use App\Controllers\Admin\AdminController;
use App\Controllers\App\HomeController;
use App\Controllers\AuthController;
use App\Controllers\Admin\UserController;
use App\Controllers\App\QuotesController;
use App\Controllers\App\ContactController;

// Middleware imports
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

// Define the base path for the application
$router->get('/', [HomeController::class, 'index']);
// Public routes
$router->get('/about', [HomeController::class, 'about']);
// Public quote routes
$router->get('/quote', [QuotesController::class, 'index']);
$router->post('/quote', [QuotesController::class, 'store']);
// Public contact routes
$router->get('/contact', [ContactController::class, 'create']);
$router->post('/contact', [ContactController::class, 'store']);

// Admin routes (protected by AuthMiddleware)
$router->middleware([AuthMiddleware::class], function ($router) {
    $router->get('/admin', [AdminController::class, 'index']);
    $router->resource('/admin/users', UserController::class)
        ->middleware(RoleMiddleware::class, ['create', 'store', 'destroy']);
    // Admin user profile route
    $router->get('/admin/profile', [UserController::class, 'profile']);
    // $router->resource('/admin/events', EventController::class);
    $router->get('/logout', [AuthController::class, 'logout']);
    $router->post('/logout', [AuthController::class, 'logout']);
});

// Authentication routes
// Redirect logged-in users away from /login
$router->get('/login', function () {
    if (class_exists('App\\Helpers\\Auth')) {
        $auth = 'App\\Helpers\\Auth';
    } elseif (class_exists('Auth')) {
        $auth = 'Auth';
    } else {
        require_once __DIR__ . '/../app/helpers/Auth.php';
        $auth = 'Auth';
    }
    if ($auth::check()) {
        header('Location: ' . url('/admin'));
        exit;
    }
    (new App\Controllers\AuthController)->showLogin();
});
$router->post('/login', [AuthController::class, 'login']);

// Initial setup routes
// Show setup page if no users exist
$router->get('/setup', [AuthController::class, 'setup']);
$router->post('/setup', [AuthController::class, 'storeSetup']);

// Generic page route
// this is for showing static pages based on the page title like privacy, terms, etc.
// This route will call the page method in HomeController with the page title as a parameter
$router->get('/{pageTitle}', [HomeController::class, 'page']);
