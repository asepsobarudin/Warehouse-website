<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/cashier', 'CashierController::index');
$routes->get('/product', 'CashierController::product');
$routes->post('/search', 'CashierController::search');
$routes->post('/category', 'CashierController::getByCategory');

$routes->get('/goods', 'GoodsController::index');
