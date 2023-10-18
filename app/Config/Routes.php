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
$routes->get('/goods_detail/(:segment)', 'GoodsController::detail/$1');
$routes->match(['get', 'post'], '/goods_create', 'GoodsController::create');
$routes->get('/goods_edit/(:segment)', 'GoodsController::edit/$1');
$routes->post('/goods_update', 'GoodsController::update');
$routes->post('/goods_delete', 'GoodsController::delete');
