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
$routes->match(['get', 'post'], 'users/create', 'UserController::create', ['filter' => 'auth:admin']);
$routes->get('/users/edit/(:segment)', 'UserController::edit/$1', ['filter' => 'auth:admin']);
$routes->post('/users/update', 'UserController::update', ['filter' => 'auth:admin']);
$routes->post('/users/delete', 'UserController::delete', ['filter' => 'auth:admin']);
$routes->post('/users/remove_access', 'UserController::removeAccess', ['filter' => 'auth:admin']);

$routes->get('/cashier', 'CashierController::index', ['filter' => 'auth:kasir,admin']);

$routes->match(['get', 'post'], '/goods', 'GoodsController::index', ['filter' => 'auth:gudang,kasir,admin']);
$routes->match(['get', 'post'], '/goods/create', 'GoodsController::create', ['filter' => 'auth:gudang,admin']);
$routes->get('/goods/edit/(:segment)', 'GoodsController::edit/$1', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/update', 'GoodsController::update', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/stock', 'GoodsController::updateStock', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/delete', 'GoodsController::delete', ['filter' => 'auth:gudang,admin']);
$routes->get('/goods/trash', 'GoodsController::trash', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/restore', 'GoodsController::restore', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/delete_trash', 'GoodsController::deleteTrash', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/delete_all_trash', 'GoodsController::deleteAllTrash', ['filter' => 'auth:gudang,admin']);

// Json Response
$routes->get('/goods/goods_list', 'GoodsController::goodsList', ['filter' => 'auth:gudang,kasir,admin']);
$routes->post('/goods/goods_search', 'GoodsController::goodsSearch', ['filter' => 'auth:gudang,kasir,admin']);
//End Json Response

// View
$routes->get('/restock', 'RestockController::index', ['filter' => 'auth:kasir,gudang,admin']);
// Request Cashier
$routes->match(['get', 'post'], '/restock/create', 'RestockController::create', ['filter' => 'auth:kasir,admin']);
$routes->get('/restock/edit/(:segment)', 'RestockController::edit/$1', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/delete', 'RestockController::delete', ['filter' => 'auth:kasir,admin']);
$routes->post('restock/cancle', 'RestockController::cancle', ['filter' => 'auth:kasir,admin']);
$routes->get('/restock/details/(:segment)', 'RestockController::details/$1', ['filter' => 'auth:kasir,gudang,admin']);
// Delete and Restore
$routes->get('/restock/trash', 'RestockController::trash', ['filter' => 'auth:kasir,gudang,admin']);
$routes->post('/restock/restore', 'RestockController::restore', ['filter' => 'auth:kasir,gudang,admin']);
$routes->post('/restock/delete_trash', 'RestockController::deleteTrash', ['filter' => 'auth:kasir,gudang,admin']);
$routes->post('/restock/delete_all_trash', 'RestockController::deleteAllTrash', ['filter' => 'auth:kasir,gudang,admin']);
// Response Warehouse
$routes->get('/restock/get_restock/(:segment)', 'RestockController::getRestock/$1', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/send_restock', 'RestockController::sendRestock', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/cancle_send', 'RestockController::cancleSend', ['filter' => 'auth:gudang,admin']);

// Json Response
$routes->post('/restock/add_goods', 'RestockController::addGoods', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/list_goods', 'RestockController::listGoods', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/add_qty', 'RestockController::addQty', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/delete_goods', 'RestockController::deleteGoods', ['filter' => 'auth:kasir,admin']);
$routes->post('/restock/restock_list', 'RestockController::restockList', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/add_send', 'RestockController::addSend', ['filter' => 'auth:gudang,admin']);
//End Json Response

