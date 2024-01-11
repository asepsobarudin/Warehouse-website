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

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
// Json
$routes->post('/goods_history', 'DashboardController::history', ['filter' => 'auth']);
$routes->post('/goods_in_out', 'DashboardController::getGoodsInOut', ['filter' => 'auth']);
// End Json
$routes->get('/trash', 'DashboardController::trash', ['filter' => 'auth:admin']);

$routes->get('/history', 'HistoryController::index', ['filter' => 'auth:admin']);
// SJson
$routes->get('/history/history_list', 'HistoryController::history', ['filter' => 'auth:admin']);
$routes->post('/history/history_date', 'HistoryController::getDate', ['filter' => 'auth:admin']);
// End Json

$routes->match(['get', 'post'], '/users', 'UserController::index', ['filter' => 'auth:admin']);
$routes->match(['get', 'post'], 'users/create', 'UserController::create', ['filter' => 'auth:admin']);
$routes->get('/users/edit/(:segment)', 'UserController::edit/$1', ['filter' => 'auth:admin']);
$routes->post('/users/update', 'UserController::update', ['filter' => 'auth:admin']);
$routes->post('/users/delete', 'UserController::delete', ['filter' => 'auth:admin']);
$routes->post('/users/remove_access', 'UserController::removeAccess', ['filter' => 'auth:admin']);

$routes->match(['get', 'post'], '/goods', 'GoodsController::index', ['filter' => 'auth:gudang,admin']);
$routes->match(['get', 'post'], '/goods/create', 'GoodsController::create', ['filter' => 'auth:gudang,admin']);
$routes->get('/goods/edit/(:segment)', 'GoodsController::edit/$1', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/update', 'GoodsController::update', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/stock', 'GoodsController::updateStock', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/delete', 'GoodsController::delete', ['filter' => 'auth:gudang,admin']);
// Json
$routes->get('/goods/trash', 'GoodsController::trash', ['filter' => 'auth:gudang,admin']);
// End JSon
$routes->post('/goods/restore', 'GoodsController::restore', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/delete_trash', 'GoodsController::deleteTrash', ['filter' => 'auth:gudang,admin']);
// Json
$routes->match(['get', 'post'], '/goods/add_stock', 'GoodsController::addStock', ['filter' => 'auth:gudang,admin']);
// End Json

// Json Response
$routes->get('/goods/goods_list', 'GoodsController::goodsList', ['filter' => 'auth:gudang,admin']);
$routes->post('/goods/goods_search', 'GoodsController::goodsSearch', ['filter' => 'auth:gudang,admin']);
//End Json Response

// CRUD Restock
$routes->get('/restock', 'RestockController::index', ['filter' => 'auth:gudang,admin']);
$routes->match(['get', 'post'], '/restock/create', 'RestockController::create', ['filter' => 'auth:gudang,admin']);
$routes->get('/restock/edit/(:segment)', 'RestockController::edit/$1', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/delete', 'RestockController::delete', ['filter' => 'auth:gudang,admin']);
$routes->get('/restock/details/(:segment)', 'RestockController::details/$1', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/cancle', 'RestockController::cancle', ['filter' => 'auth:gudang,admin']);
// Delete and Restore
$routes->get('/restock/trash', 'RestockController::trash', ['filter' => 'auth:admin']);
$routes->post('/restock/restore', 'RestockController::restore', ['filter' => 'auth:admin']);
$routes->post('/restock/delete_trash', 'RestockController::deleteTrash', ['filter' => 'auth:admin']);

// Json Response
$routes->post('/restock/add_goods', 'RestockController::addGoods', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/list_goods', 'RestockController::listGoods', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/add_qty', 'RestockController::addQty', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/delete_goods', 'RestockController::deleteGoods', ['filter' => 'auth:gudang,admin']);
$routes->get('/restock/restock_list', 'RestockController::restockList', ['filter' => 'auth:gudang,admin']);
$routes->post('/restock/restock_date', 'RestockController::getDate', ['filter' => 'auth:gudang,admin']);
//End Json Response

