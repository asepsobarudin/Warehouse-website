<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'AuthController::index');
 $routes->post('/auth', 'AuthController::login');
 $routes->get('/logout', 'AuthController::logOut');

$routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);
$routes->get('/cashier', 'CashierController::index', ['filter' => 'auth:kasir,']);
$routes->get('/product', 'CashierController::product', ['filter' => 'auth:kasir,']);
$routes->post('/search', 'CashierController::search', ['filter' => 'auth:kasir,']);
$routes->get('/goods_detail/(:segment)', 'GoodsController::detail/$1');

$routes->get('/goods', 'GoodsController::index', ['filter' => 'auth:gudang,kasir']);
$routes->match(['get', 'post'], '/goods/goods_create', 'GoodsController::create');
$routes->get('/goods/goods_edit/(:segment)', 'GoodsController::edit/$1');
$routes->post('/goods/goods_update', 'GoodsController::update');
$routes->post('/goods/goods_stock', 'GoodsController::updateStock');
$routes->post('/goods/goods_delete', 'GoodsController::delete');

$routes->get('/stock', function () {
  return view ('pages/cashier/request_stok/stock_pages', ['title' => 'Stok']);
});
