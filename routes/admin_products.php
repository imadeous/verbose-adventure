<?php
// Resource routes for admin/products
$router->get('admin/products', 'Admin\\ProductsController@index');
$router->get('admin/products/create', 'Admin\\ProductsController@create');
$router->post('admin/products', 'Admin\\ProductsController@store');
$router->get('admin/products/{id}', 'Admin\\ProductsController@show');
$router->get('admin/products/{id}/edit', 'Admin\\ProductsController@edit');
$router->post('admin/products/{id}/update', 'Admin\\ProductsController@update');
$router->post('admin/products/{id}/delete', 'Admin\\ProductsController@destroy');
