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
use App\Controllers\AuthController;

use App\Controllers\App\HomeController;
use App\Controllers\App\ContactController;
use App\Controllers\App\GalleryController;

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\UserController as AdminUserController;
use App\Controllers\Admin\ContactController as AdminContactController;
use App\Controllers\Admin\ReviewsController as AdminReviewsController;
use App\Controllers\Admin\ProductsController as AdminProductsController;
use App\Controllers\Admin\CategoriesController as AdminCategoriesController;
use App\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Controllers\Admin\VariantsController as AdminVariantsController;
use App\Controllers\Admin\AssistantController as AdminAssistantController;
use App\Controllers\Admin\CustomersController as AdminCustomersController;

// Middleware imports
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

// Define the base path for the application
$router->get('/', [HomeController::class, 'index']);
// Public routes
// Public gallery route
$router->get('/gallery', [GalleryController::class, 'index']);
// Public contact routes
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'store']);
// Public product detail route (must be last to avoid catching other routes)
$router->get('/product/{id}', [GalleryController::class, 'show']);
//Order placement routes
$router->get('/buy/{variantId}', [GalleryController::class, 'buy']);
$router->get('/request/{variantId}', [GalleryController::class, 'requestQuote']);
$router->post('/order', [GalleryController::class, 'placeOrder']);

// Static pages
$router->get('/about', [HomeController::class, 'about']);
$router->get('/terms', [HomeController::class, 'terms']);
$router->get('/privacy', [HomeController::class, 'privacy']);


// Admin routes (protected by AuthMiddleware) => Login required
$router->middleware([AuthMiddleware::class], function ($router) {
    $router->get('/admin', [AdminController::class, 'index']);
    $router->get('/admin/debug', [AdminController::class, 'debug']);
    $router->get('/admin/transaction-calendar-data', [AdminController::class, 'transactionCalendarData']);
    $router->resource('/admin/users', AdminUserController::class)
        ->middleware(RoleMiddleware::class, ['create', 'store', 'destroy']);
    $router->resource('/admin/contacts', AdminContactController::class);
    $router->resource('/admin/reviews', AdminReviewsController::class);
    $router->resource('/admin/products', AdminProductsController::class);
    $router->resource('/admin/transactions', AdminTransactionController::class);
    // Custom transaction routes for separate income/expense forms
    $router->get('/admin/transactions/income/create', [AdminTransactionController::class, 'createIncome']);
    $router->post('/admin/transactions/income', [AdminTransactionController::class, 'storeIncome']);
    $router->get('/admin/transactions/expense/create', [AdminTransactionController::class, 'createExpense']);
    $router->post('/admin/transactions/expense', [AdminTransactionController::class, 'storeExpense']);
    $router->get('/admin/reports', [AdminController::class, 'reports']);
    // Product image upload routes
    $router->get('/admin/products/{id}/addImage', [AdminProductsController::class, 'addImage']);
    $router->post('/admin/products/{id}/addImage', [AdminProductsController::class, 'storeImage']);
    // Product variant routes (inline creation/editing on product page)
    $router->get('/admin/products/{id}/variants-json', [AdminProductsController::class, 'variantsJson']);
    $router->post('/admin/products/{id}/variants', [AdminVariantsController::class, 'store']);
    $router->post('/admin/products/{productId}/variants/{variantId}/delete', [AdminVariantsController::class, 'destroy']);
    $router->post('/admin/variants/{variantId}/add-stock', [AdminVariantsController::class, 'addStock']);
    $router->get('/admin/variants/lookup-sku', [AdminVariantsController::class, 'lookupSKU']);
    $router->get('/admin/categories/tree', [AdminCategoriesController::class, 'tree']);
    $router->resource('/admin/categories', AdminCategoriesController::class);
    $router->resource('/admin/gallery', AdminGalleryController::class);
    // Customers routes
    $router->get('/admin/customers', [AdminCustomersController::class, 'index']);
    // AI Assistant routes
    $router->get('/admin/assistant', [AdminAssistantController::class, 'index']);
    // Individual analysis shortcuts
    $router->get('/admin/assistant/swot', [AdminAssistantController::class, 'swot']);
    $router->get('/admin/assistant/revenue', [AdminAssistantController::class, 'revenue']);
    $router->get('/admin/assistant/forecast', [AdminAssistantController::class, 'forecast']);
    $router->get('/admin/assistant/stock', [AdminAssistantController::class, 'stock']);
    $router->get('/admin/assistant/csat', [AdminAssistantController::class, 'csat']);
    $router->get('/admin/assistant/statistics', [AdminAssistantController::class, 'statistics']);
    // Legacy analysis form (can be kept or removed)
    $router->get('/admin/assistant/analyze', [AdminAssistantController::class, 'analyze']);
    $router->post('/admin/assistant/analyze/generate', [AdminAssistantController::class, 'generateAnalysis']);
    // AI Sandbox
    $router->get('/admin/assistant/sandbox', [AdminAssistantController::class, 'sandbox']);
    $router->post('/admin/assistant/sandbox/execute', [AdminAssistantController::class, 'runSandbox']);
    // Admin user profile route
    $router->get('/admin/profile', [AdminUserController::class, 'profile']);
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
