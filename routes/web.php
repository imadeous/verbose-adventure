<?php

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\DebugController;
use App\Controllers\App\ErrorController;
use App\Controllers\App\HomeController;
use App\Controllers\Admin\ProductController;
use App\Controllers\Admin\TableController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\SettingsController;
use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

use Core\Router;

$router->get('', [HomeController::class, 'index']);
$router->get('/', [HomeController::class, 'index']);

// Auth Routes
$router->get('login', [AuthController::class, 'login']);
$router->post('login', [AuthController::class, 'attempt']);
$router->post('logout', [AuthController::class, 'logout']);

// Admin routes
$router->group(['middleware' => ['auth', 'role:admin']], function (Router $router) {
    $router->get('admin', [AdminController::class, 'index']);

    // Table Creator routes
    $router->get('admin/tables', [TableController::class, 'index']);
    $router->get('admin/tables/create', [TableController::class, 'create']);
    $router->post('admin/tables/store', [TableController::class, 'store']);
    $router->get('admin/tables/alter/{tableName}', [TableController::class, 'alter']);
    $router->post('admin/tables/alter/add-column', [TableController::class, 'addColumn']);
    $router->post('admin/tables/alter/drop-column', [TableController::class, 'dropColumn']);
    $router->post('admin/tables/destroy', [TableController::class, 'destroy']);

    // Debug Route
    $router->get('admin/debug', [DebugController::class, 'index']);

    // User Management routes
    $router->get('admin/users', [UserController::class, 'index']);
    $router->get('admin/users/create', [UserController::class, 'create']);
    $router->post('admin/users', [UserController::class, 'store']);
    $router->get('admin/users/show/{id}', [UserController::class, 'show']);
    $router->get('admin/users/edit/{id}', [UserController::class, 'edit']);
    $router->post('admin/users/update/{id}', [UserController::class, 'update']);
    $router->post('admin/users/destroy/{id}', [UserController::class, 'destroy']);

    // User Profile routes
    $router->get('admin/profile', [UserController::class, 'profile']);
    $router->post('admin/profile/avatar', [UserController::class, 'updateAvatar']);

    // Product routes
    $router->get('admin/products', [ProductController::class, 'index']);
    $router->get('admin/products/create', [ProductController::class, 'create']);
    $router->post('admin/products', [ProductController::class, 'store']);
    $router->get('admin/products/{id}', [ProductController::class, 'show']);
    $router->get('admin/products/{id}/edit', [ProductController::class, 'edit']);
    $router->post('admin/products/{id}', [ProductController::class, 'update']); // Should be PUT/PATCH, but HTML forms only support GET/POST
    $router->post('admin/products/destroy/{id}', [ProductController::class, 'destroy']); // Should be DELETE


    // Settings routes
    $router->get('admin/settings', [SettingsController::class, 'index']);
    $router->get('admin/settings/analytics', [SettingsController::class, 'analytics']);
    $router->post('admin/settings/analytics', [SettingsController::class, 'updateAnalytics']);
    $router->post('admin/settings/managed-tables', [SettingsController::class, 'updateManagedTables']);
});

// API routes are not behind the admin role middleware
$router->get('api/managed-tables', [SettingsController::class, 'getManagedTablesJson']);

// Handle 404
$router->addNotFoundHandler([ErrorController::class, 'notFound']);

// Example of a resource route
// $router->resource('tasks', 'TaskController');
