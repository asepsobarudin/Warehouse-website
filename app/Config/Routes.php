<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');
$routes->post('/auth', 'AuthController::login');
$routes->get('/back', 'AuthController::back');

$routes->post('/logout', 'AuthController::logOut', ['filter' => 'auth']);
$routes->get('/auth/online', 'AuthController::online', ['filter' => 'auth:online']);
$routes->post('/auth/remove_online', 'AuthController::removeOnline', ['filter' => 'auth:online']);

$routes->get('/dashboard', 'Home::index', ['filter' => 'auth']);
$routes->get('/menu', 'Home::menu', ['filter' => 'auth']);

$routes->match(['get', 'post'], '/users', 'UserController::index', ['filter' => 'auth:admin']);
$routes->match(['get', 'post'], 'users/users_create', 'UserController::create', ['filter' => 'auth:admin']);
$routes->get('/users/users_edit/(:segment)', 'UserController::edit/$1', ['filter' => 'auth:admin']);
$routes->post('/users/users_update', 'UserController::update', ['filter' => 'auth:admin']);
$routes->post('/users/users_delete', 'UserController::delete', ['filter' => 'auth:admin']);
$routes->post('/users/remove_access', 'UserController::removeAccess', ['filter' => 'auth:admin']);

$routes->get('/cashier', 'CashierController::index', ['filter' => 'auth:kasir,admin']);

$routes->match(['get', 'post'], '/goods', 'GoodsController::index', ['filter' => 'auth:gudang,kasir,admin']);
$routes->match(['get', 'post'], '/goods/goods_create', 'GoodsController::create', ['filter' => 'auth:gudang,admin']);
$routes->get('/goods/goods_edit/(:segment)', 'GoodsController::edit/$1', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_update', 'GoodsController::update', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_stock', 'GoodsController::updateStock', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_delete', 'GoodsController::delete', ['filter' => 'auth:gudang,admin']);

// Json Response
$routes->get('/goods/goods_list', 'GoodsController::goodsList', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_search', 'GoodsController::goodsSearch', ['filter' => 'auth:gudang,kasir,admin']);

$routes->get('/restock', 'RestockController::index', ['filter' => 'auth:kasir,admin']);
$routes->match(['get', 'post'], '/restock/restock_create', 'RestockController::create', ['filter' => 'auth:kasir,admin']);
$routes->get('/restock/restock_edit/(:segment)', 'RestockController::edit/$1', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/restock_delete', 'RestockController::delete', ['filter' => 'auth:kasir,admin']);
$routes->post('restock/restock_cancle', 'RestockController::cancle', ['filter' => 'auth:kasir,admin']);
$routes->get('/restock/restock_details/(:segment)', 'RestockController::details/$1', ['filter' => 'auth:kasir,gudang,admin']);

// Json Response
$routes->post('/restock/add_goods', 'RestockController::addGoods', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/list_goods', 'RestockController::listGoods', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/add_qty', 'RestockController::addQty', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/delete_goods', 'RestockController::deleteGoods', ['filter' => 'auth:kasir,admin']);

$routes->get('/distribution', 'DistributionController::index', ['filter' => 'auth:gudang,admin']);
$routes->get('/distribution/get_restock/(:segment)', 'DistributionController::getRestock/$1', ['filter' => 'auth:gudang,admin']);
$routes->post('/distribution/send_restock', 'DistributionController::sendRestock', ['filter' => 'auth:gudang,admin']);
$routes->post('/distribution/cancle_send', 'DistributionController::cancleSend', ['filter' => 'auth:gudang,admin']);

$routes->post('/distribution/restock_list', 'DistributionController::restockList', ['filter' => 'auth:gudang,admin']);
$routes->post('/distribution/add_send', 'DistributionController::addSend', ['filter' => 'auth:gudang,admin']);
