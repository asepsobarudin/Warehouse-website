<?php

namespace App\Controllers;

use DateTime;
use Config\Services;
use App\Models\Goods;
use App\Models\Users;
use App\Models\Restock;
use App\Helpers\JwtHelpers;
use App\Models\GoodsRestock;
use App\Controllers\BaseController;

class RestockController extends BaseController
{
    protected $Restock, $GoodsRestock, $Goods, $Users, $JwtHelpers;
    public function __construct()
    {
        $this->Restock = new Restock();
        $this->GoodsRestock = new GoodsRestock();
        $this->Goods = new Goods();
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
    }

    public function index()
    {
        $data = [
            'title' => 'Kirim Barang',
        ];

        return view('pages/restock/restock_page', $data);
    }

    // Json
    public function restockList()
    {
        $restockList = $this->Restock->getPaginate();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $restock = [];

        if (isset($decoded->role) && $decoded->role === 'gudang') {
            foreach ($restockList as $list) {
                if (isset($list['user_id']) && $list['user_id'] === $decoded->username) {
                    $goodsList = $this->GoodsRestock->listRestock($list['id']);
                    $length = count($goodsList);
                    $list = array_merge($list, ['qty' => $length]);
                    unset($list['id']);
                    $restock = array_merge($restock, [$list]);
                }
            }
        }

        if (isset($decoded->role) && $decoded->role === 'admin') {
            foreach ($restockList as $list) {
                $goodsList = $this->GoodsRestock->listRestock($list['id']);
                $length = count($goodsList);
                $list = array_merge($list, ['qty' => $length]);
                unset($list['id']);
                $restock = array_merge($restock, [$list]);
            }
        }

        $data = [
            'restock' => $restock,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'perPage' => $this->Pager->getPerPage(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $this->Pager->getNextPageURI(),
            'backPage' => $this->Pager->getPreviousPageURI()
        ];

        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }

    public function getDate()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if (!isset($csrfToken) || $csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['search'])) {
            $restockList = $this->Restock->searchListRestock($body['search']);
            $session = $this->SessionHelpers->getSession();
            $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
            $restock = [];

            if (isset($decoded->role) && $decoded->role === 'gudang') {
                foreach ($restockList as $list) {
                    if (isset($list['user_id']) && $list['user_id'] === $decoded->username) {
                        $goodsList = $this->GoodsRestock->listRestock($list['id']);
                        $length = count($goodsList);
                        $list = array_merge($list, ['qty' => $length]);
                        unset($list['id']);
                        $restock = array_merge($restock, [$list]);
                    }
                }
            }

            if (isset($decoded->role) && $decoded->role === 'admin') {
                foreach ($restockList as $list) {
                    $goodsList = $this->GoodsRestock->listRestock($list['id']);
                    $length = count($goodsList);
                    $list = array_merge($list, ['qty' => $length]);
                    unset($list['id']);
                    $restock = array_merge($restock, [$list]);
                }
            }

            $data = [
                'restock' => $restock,
            ];

            $this->response->setContentType('application/json');
            return $this->response->setJSON($data);
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Input tidak valid!']);
        }
    }
    // End Json

    public function create()
    {
        $body = $this->request->getPost();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);
        $validated = \Config\Services::validation();

        if ($body) {
            $restock = null;
            if (isset($body[csrf_token()]) != csrf_hash()) {
                $body = null;
                session()->setFlashdata('errors', 'Permintaan restock gagal dibuat!');
                return redirect()->back();
            }

            if (isset($body['restock_code'])) {
                $restock = $this->Restock->getOneData($body['restock_code']);
            }

            if ($restock && isset($restock['restock_code'])) {
                $restock = $this->Restock->getOneData($restock['restock_code']);
                $listRestock = $this->GoodsRestock->listRestock($restock['id']);
                foreach ($listRestock as $list) {
                    $goods = $this->Goods->getDataById($list['goods_id']);
                    if (!$goods) {
                        session()->setFlashdata('errors', 'Ada data barang yang tidak ditemukan!');
                        return redirect()->back();
                    }
                }

                if (count($listRestock) == 0) {
                    session()->setFlashdata('errors', 'Silahkan masukan barang!');
                    return redirect()->back();
                }
            }

            $data = [
                'status' => 1,
                'user_id' => $users['id'],
            ];

            $rules = $this->Restock->getValidationRules();
            $message = $this->Restock->getValidationMessages();
            unset($rules['restock_code'], $rules['response_user_id']);
            $this->Restock->setValidationRules($rules);

            if (isset($users['id']) != isset($restock['user_id'])) {
                $data = array_merge($data, ['user_id' => $users['id']]);
            }

            if ($this->validateData($data, $rules, $message)) {
                if (($restock && isset($restock['id']) && $this->Restock->update($restock['id'], $data))) {
                    session()->setFlashdata('success', 'Permintaan restock berhasil dibuat');
                    return redirect()->to('restock');
                } else {
                    session()->setFlashdata('errors', 'Permintaan restock gagal dibuat!');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('errors', $validated->listErrors());
                return redirect()->back();
            }
        } else {
            $data = [
                'title' => 'Buat Pengiriman',
                'link' => '/restock',
                'restock_code' => $this->Restock->uniqueCode()
            ];
            return view('pages/restock/restock_create', $data);
        }
    }

    // JSON
    public function addGoods()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $validated = \Config\Services::validation();

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            $users = $this->Users->getUser($decoded->username);
            $goods = $this->Goods->getOneData($body['goods']);
            $rules = $this->Restock->getValidationRules();
            $message = $this->Restock->getValidationMessages();
            unset($rules['user_id']);
            $this->Restock->setValidationRules($rules);

            if (!$restock) {
                $data = [
                    'restock_code' => $body['restock'],
                    'status' => 0,
                    'user_id' => $users['id'],
                ];

                if ($this->validateData($data, $rules, $message) && $this->Restock->insert($data)) {
                    $restock = $this->Restock->getOneData($body['restock']);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => $validated->listErrors()]);
                }
            }

            if ($restock && $goods) {
                if (isset($goods['goods_stock_warehouse']) && $goods['goods_stock_warehouse'] >= 1) {
                    $data = [
                        'goods_id' => $goods['id'],
                        'restock_id' => $restock['id'],
                        'qty' => 1,
                    ];
                    $goodsValue = $goods['goods_stock_warehouse'] - 1;
                    $this->Goods->update($goods['id'], ['goods_stock_warehouse' => $goodsValue]);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Barang pada gundang habis!']);
                }

                $rules = $this->GoodsRestock->getValidationRules();
                $message = $this->GoodsRestock->getValidationMessages();
                if (!$this->validateData($data, $rules, $message)) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => $validated->listErrors()]);
                } else {
                    if (!$this->GoodsRestock->checkList($data['restock_id'], $data['goods_id']) && $this->GoodsRestock->insert($data)) {
                        $this->Restock->update($restock['id'], ['status' => 0]);
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['restock' => $restock['restock_code'], 'success' => 'Barang berhasil ditambahkan.']);
                    } else {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['errors' => 'Barang sudah ditambahkan!']);
                    }
                }
            } else {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Data barang tidak ditemukan!']);
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Penambahan barang gagal dilakukan!!']);
        }
    }


    public function listGoods()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            $listRestock = $this->GoodsRestock->listRestock($restock['id']);
            $goodsList = [];
            $goodsEmpty = 0;
            foreach ($listRestock as $list) {
                $goods = $this->Goods->getDataById($list['goods_id']);
                $restock = $this->Restock->getDataById($list['restock_id']);
                if (!$goods) {
                    $goodsEmpty = 1;
                }

                if ($goods) {
                    $list = array_merge($list, ['goods_code' => $goods['goods_code']]);
                    $list = array_merge($list, ['goods_name' => $goods['goods_name']]);
                } else {
                    $list = array_merge($list, ['goods_code' => null]);
                    $list = array_merge($list, ['goods_name' => 'Barang tidak di temukan!']);
                }
                unset($list['id']);
                unset($list['goods_id']);
                unset($list['restock_id']);
                $list = array_merge($list, ['restock_code' => $restock['restock_code']]);
                $goodsList = array_merge($goodsList, [$list]);
            }

            if ($goodsEmpty < 1) {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['data' => $goodsList, 'status' => $restock['status']]);
            } else {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['data' => $goodsList, 'status' => $restock['status'], 'errors' => 'Ada data barang yang tidak ditemukan!']);
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'List barang restock tidak ditemukan!']);
        }
    }

    public function addQty()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);
        $validated = \Config\Services::validation();

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }


        if ($body && isset($body['restock']) && isset($body['goods']) && isset($body['qty'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            $rules = $this->GoodsRestock->getValidationRules();
            $message = $this->GoodsRestock->getValidationMessages();


            if ($body['goods'] == 'null' || $body['goods'] == '') {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Barang tidak ditemukan!']);
            }

            $goods = $this->Goods->getOneData($body['goods']);
            $idGoods = $this->GoodsRestock->checkList($restock['id'], $goods['id']);
            $value = $body['qty'];

            $data = [
                'goods_id' => $goods['id'],
                'restock_id' => $restock['id'],
                'status' => 0,
                'qty' => $body['qty']
            ];

            if ($data['qty'] < 1) {
                $data['qty'] = null;
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Jumlah barang tidak boleh kurang dari 1!']);
            }

            if ($idGoods['qty'] == $data['qty']) {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Jumlah yang dimasukan sama dengan yang sebelumnya!']);
            }

            $resultValue = 0;
            $goodsValue = 0;
            if ($body['qty'] > $idGoods['qty']) {
                $resultValue =  $value - $idGoods['qty'];
                $data['qty'] = $idGoods['qty'] + $resultValue;
                $goodsValue = $goods['goods_stock_warehouse'] - $resultValue;
            }

            if ($body['qty'] < $idGoods['qty']) {
                $resultValue = $idGoods['qty'] - $value;
                $data['qty'] = $idGoods['qty'] - $resultValue;
                $goodsValue = $goods['goods_stock_warehouse'] + $resultValue;
            }


            if ($this->validateData($data, $rules, $message)) {
                if (($idGoods && isset($idGoods['id']) && isset($idGoods['goods_id'])) && ($resultValue >= 1 && $goodsValue >= 1) && $this->GoodsRestock->update($idGoods['id'], $data) && $this->Goods->update($idGoods['goods_id'], ['goods_stock_warehouse' => $goodsValue])) {
                    $this->Restock->update($restock['id'], ['status' => 0]);
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['success' => 'Jumlah barang berhasil diubah!']);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Jumlah barang gagal untuk diubah!']);
                }
            } else {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => $validated->listErrors()]);
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Input Invalid!']);
        }
    }

    public function deleteGoods()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock']) && isset($body['goods'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            if ($restock) {
                $goods = $this->Goods->getOneData($body['goods']);

                if (!$goods) {
                    $listRestock = $this->GoodsRestock->listRestock($restock['id']);
                    foreach ($listRestock as $list) {
                        $goods = $this->Goods->getDataById($list['goods_id']);
                        if (!$goods) {
                            $this->GoodsRestock->delete($list['id']);
                            $this->response->setContentType('application/json');
                            return $this->response->setJSON(['success' => 'Barang yang tidak ditemukan berhasil di hapus']);
                        }
                    }
                }

                $idGoods = $this->GoodsRestock->checkList($restock['id'], $goods['id']);
                $load = 0;
                if (isset($idGoods['qty']) && $idGoods > 0) {
                    $load = 1;
                    $goodsValue = $goods['goods_stock_warehouse'] + $idGoods['qty'];
                    $this->Goods->update($goods['id'], ['goods_stock_warehouse' => $goodsValue]);
                }

                if (isset($idGoods['id']) && $this->GoodsRestock->delete($idGoods['id'])) {
                    $this->Restock->update($restock['id'], ['status' => 0]);
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['success' => 'Barang berhasil dihapus!', 'load' => $load]);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Barang gagal dihapus!']);
                }
            } else {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Barang gagal dihapus!']);
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Barang gagal dihapus!']);
        }
    }
    // End JSON

    public function edit($code)
    {
        $restock = $this->Restock->getOneData($code);
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if ($users['id'] === $restock['user_id'] || $decoded->role === "admin") {
            $data = [
                'title' => 'Edit Pengiriman',
                'link' => '/restock',
                'status' => $restock['status'],
                'restock_code' => $restock['restock_code']
            ];
            return view('pages/restock/restock_edit', $data);
        } else {
            session()->setFlashdata('errors', 'Anda tidak di izinkan dapat mengedit permintaan restock!');
            return redirect()->back();
        }
    }

    public function delete()
    {
        $body = $this->request->getPost();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock'])) {
            $restock = $this->Restock->getOneData($body['restock']);

            if (!isset($restock)) {
                session()->setFlashdata('errors', 'Data restock tidak ditemukan!');
                return redirect()->back();
            }

            if ($users['id'] === $restock['user_id'] || $decoded->role === "admin") {
                if ($restock && ($restock['status'] == 1 && $this->Restock->delete($restock['id'])) || ($restock['status'] == 0 && $this->Restock->delete($restock['id'], true))) {
                    $goodsRestock = $this->GoodsRestock->listRestock($restock['id']);
                    if ($restock['status'] == 0 && count($goodsRestock) != 0) {
                        foreach ($goodsRestock as $list) {
                            if ($list['qty'] != 0) {
                                $goods = $this->Goods->getDataById($list['goods_id']);
                                if (isset($goods['id'])) {
                                    $goodsValue = $goods['goods_stock_warehouse'] + $list['qty'];
                                    $this->Goods->update($goods['id'], ['goods_stock_warehouse' => $goodsValue]);
                                    $this->GoodsRestock->delete($list['id']);
                                }
                            } else {
                                $this->GoodsRestock->delete($list['id']);
                            }
                        }
                    }
                    session()->setFlashdata('success', 'Data permintaan restock berhasil di hapus.');
                    return redirect()->back();
                } else {
                    session()->setFlashdata('errors', 'Gagal menghapus data permintaan restock!');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('errors', 'Anda tidak dapat menghapus permintaan restock!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Data permintaan restock tidak ditemukan! ');
            return redirect()->back();
        }
    }

    public function cancle()
    {
        $body = $this->request->getPost();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }


        if ($body && isset($body['restock_code'])) {
            $restock = $this->Restock->getOneData($body['restock_code']);
            if (isset($restock['status']) && $restock['status'] == 1) {
                if ($users['id'] === $restock['user_id'] || $decoded->role === "admin") {
                    if ($this->Restock->update($restock['id'], ['status' => 0])) {
                        session()->setFlashdata('success', 'Pengiriman restock berhasil di batalkan.');
                        return redirect()->to('/restock');
                    } else {
                        session()->setFlashdata('errors', 'Pengiriman restock gagal di batalkan!');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('errors', 'Anda tidak dapat membatalkan pengiriman restock!');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('errors', 'Pengiriman gagal dibatalkan!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Data restock tidak ditemukan! ');
            return redirect()->back();
        }
    }

    public function details($code)
    {
        $restock = $this->Restock->getOneData($code);
        if ($restock) {
            $listRestock = $this->GoodsRestock->listRestock($restock['id']);
            $goodsList = [];
            foreach ($listRestock as $list) {
                $goods = $this->Goods->getDataById($list['goods_id']);
                unset($list['id']);
                unset($list['goods_id']);
                unset($list['restock_id']);
                if ($goods) {
                    $list = array_merge($list, ['goods_code' => $goods['goods_code']]);
                    $list = array_merge($list, ['goods_name' => $goods['goods_name']]);
                    $list = array_merge($list, ['goods_stock_warehouse' => $goods['goods_stock_warehouse']]);
                } else {
                    $list = array_merge($list, ['goods_code' => '0']);
                    $list = array_merge($list, ['goods_name' => 'Barang tidak ditemukan']);
                    $list = array_merge($list, ['goods_stock_warehouse' => 0]);
                }
                $list = array_merge($list, ['restock_code' => $restock['restock_code']]);
                $goodsList = array_merge($goodsList, [$list]);
            }

            $updatedAt = strtotime($restock['updated_at']);
            $currentDateTime = time();
            $hoursDifference = $currentDateTime - $updatedAt;
            $hours = $hoursDifference > 24 * 60 * 60;

            $data = [
                'title' => 'Detail Pengiriman',
                'link' => '/restock',
                'restock' => $restock['restock_code'],
                'date' => $restock['updated_at'],
                'limit' => $hours,
                'status' => $restock['status'],
                'goods' => $goodsList,
            ];
            return view('pages/restock/restock_details', $data);
        } else {
            session()->setFlashdata('errors', 'Datar restock tidak ditemukan');
            return redirect()->back();
        }
    }

    // Json
    public function trash()
    {
        $restock = $this->Restock->onlyDeleted()->orderBy('deleted_at', 'DESC')->paginate(30);
        $setRestock = [];
        foreach ($restock as $list) {
            $goodsList = $this->GoodsRestock->listRestock($list['id']);
            $length = count($goodsList);
            $list = array_merge($list, ['qty' => $length]);
            $list['user_id'] = $this->Users->getUserId($list['user_id'])['username'];
            unset($list['id']);
            $setRestock = array_merge($setRestock, [$list]);
        }

        $lengthData = sizeof($setRestock);
        $nextURL = null;
        if ($lengthData != 0) {
            $nextURL = $this->Pager->getNextPageURI();
        }


        $data = [
            'restock' => $setRestock,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'perPage' => $this->Pager->getPerPage(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $nextURL,
            'backPage' => $this->Pager->getPreviousPageURI(),
        ];

        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }
    // End Json

    public function restore()
    {
        $body = $this->request->getPost();
        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock_code'])) {
            $restock = $this->Restock->onlyDeleted()->where('restock_code', $body['restock_code'])->first();
            $data = [
                'id' => $restock['id'],
                'deleted_at' => null
            ];

            if ($restock && $this->Restock->onlyDeleted()->save($data)) {
                session()->setFlashdata('success', 'Restock berhasil di restore.');
                return redirect()->back();
            } else {
                session()->setFlashdata('errors', 'Data restock gagal di restore!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Restock tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function deleteTrash()
    {
        $body = $this->request->getPost();
        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock_code'])) {
            $restock = $this->Restock->onlyDeleted()->where('restock_code', $body['restock_code'])->first();
            $goods = $this->GoodsRestock->listRestock($restock['id']);
            if ($restock && $this->Restock->onlyDeleted()->delete($restock['id'], true)) {
                foreach ($goods as $list) {
                    $this->GoodsRestock->delete($list['id']);
                }
                session()->setFlashdata('success', 'Restock berhasil di hapus secara permanen.');
                return redirect()->back();
            } else {
                session()->setFlashdata('errors', 'Data restock gagal di hapus!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Restock tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function getRestock($code)
    {
        $restock = $this->Restock->getOneData($code);
        if ($restock) {

            if ($restock && isset($restock['restock_code'])) {
                $restock = $this->Restock->getOneData($restock['restock_code']);
                $listRestock = $this->GoodsRestock->listRestock($restock['id']);
                foreach ($listRestock as $list) {
                    $goods = $this->Goods->getDataById($list['goods_id']);
                    if (!$goods) {
                        session()->setFlashdata('errors', 'Ada data barang yang tidak ditemukan!');
                        return redirect()->back();
                    }
                }
            }

            $data = [
                'title' => 'List permintaan',
                'link' => 'restock',
                'restock_code' => $restock['restock_code'],
                'restock_status' => $restock['status'],
            ];
            return view('pages/restock/restock_send', $data);
        } else {
            session()->setFlashdata('errors', 'Data permintaan restock tidak ditemukan!');
            return redirect()->back();
        }
    }
}
