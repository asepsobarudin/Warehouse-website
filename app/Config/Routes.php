<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');
$routes->post('/auth', 'AuthController::login');
$routes->get('/logout', 'AuthController::logOut', ['filter' => 'auth']);

$routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);

$routes->get('/users', 'UserController::index', ['filter' => 'auth:admin']);
$routes->match(['get', 'post'], 'users/add_users', 'UserController::create', ['filter' => 'auth:admin']);
$routes->get('/users/users_edit/(:segment)', 'UserController::edit/$1', ['filter' => 'auth:admin']);
$routes->post('/users/users_update', 'UserController::update', ['filter' => 'auth:admin']);
$routes->post('/users/users_delete', 'UserController::delete', ['filter' => 'auth:admin']);
$routes->post('/users/remove_access', 'UserController::removeAccess', ['filter' => 'auth:admin']);


$routes->get('/cashier', 'CashierController::index', ['filter' => 'auth:kasir,admin']);
$routes->get('/product', 'CashierController::product', ['filter' => 'auth:kasir,admin']);
$routes->post('/search', 'CashierController::search', ['filter' => 'auth:kasir,admin']);
$routes->get('/goods_detail/(:segment)', 'GoodsController::detail/$1');

$routes->get('/goods', 'GoodsController::index', ['filter' => 'auth:gudang,kasir,admin']);
$routes->match(['get', 'post'], '/goods/goods_create', 'GoodsController::create');
$routes->get('/goods/goods_edit/(:segment)', 'GoodsController::edit/$1');
$routes->post('/goods/goods_update', 'GoodsController::update');
$routes->post('/goods/goods_stock', 'GoodsController::updateStock');
$routes->post('/goods/goods_delete', 'GoodsController::delete');

$routes->get('/stock', function () {
  return view('pages/cashier/request_stok/stock_pages', ['title' => 'Stok']);
});
