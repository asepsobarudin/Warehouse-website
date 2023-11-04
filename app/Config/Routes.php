<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');
$routes->post('/auth', 'AuthController::login');

$routes->get('/logout', 'AuthController::logOut', ['filter' => 'auth']);
$routes->get('/auth/online', 'AuthController::online', ['filter' => 'auth:online']);
$routes->post('/auth/remove_online', 'AuthController::removeOnline', ['filter' => 'auth:online']);

$routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);

$routes->get('/users', 'UserController::index', ['filter' => 'auth:admin']);
$routes->match(['get', 'post'], 'users/users_create', 'UserController::create', ['filter' => 'auth:admin']);
$routes->get('/users/users_edit/(:segment)', 'UserController::edit/$1', ['filter' => 'auth:admin']);
$routes->post('/users/users_update', 'UserController::update', ['filter' => 'auth:admin']);
$routes->post('/users/users_delete', 'UserController::delete', ['filter' => 'auth:admin']);
$routes->post('/users/remove_access', 'UserController::removeAccess', ['filter' => 'auth:admin']);

$routes->get('/cashier', 'CashierController::index', ['filter' => 'auth:kasir,admin']);
$routes->get('/product', 'CashierController::product', ['filter' => 'auth:kasir,admin']);
$routes->post('/search', 'CashierController::search', ['filter' => 'auth:kasir,admin']);
$routes->get('/goods_detail/(:segment)', 'GoodsController::detail/$1');

$routes->get('/goods', 'GoodsController::index', ['filter' => 'auth:gudang,kasir,admin']);
$routes->match(['get', 'post'], '/goods/goods_create', 'GoodsController::create', ['filter' => 'auth:gudang,admin']);
$routes->get('/goods/goods_edit/(:segment)', 'GoodsController::edit/$1', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_update', 'GoodsController::update', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_stock', 'GoodsController::updateStock', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_delete', 'GoodsController::delete', ['filter' => 'auth:gudang,admin']);

$routes->get('/restock', 'RestockController::index', ['filter' => 'auth:gudang,kasir,admin']);
$routes->match(['get', 'post'], '/restock/restock_create', 'RestockController::create', ['filter' => 'auth:gudang,kasir,admin']);

$routes->post('/restock/add_goods', 'RestockController::addGoods', ['filter' => 'auth:gudang,kasir,admin']);