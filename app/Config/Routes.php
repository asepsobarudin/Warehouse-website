<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'CashierController::index');
$routes->get('/product', 'CashierController::product');
$routes->post('/search', 'CashierController::search');
