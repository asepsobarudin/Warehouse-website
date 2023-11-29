<?php

namespace App\Controllers;

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
        $restockList = $this->Restock->getPaginate();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);
        $restock = [];

        if (isset($users['role']) && $users['role'] === 'kasir') {
            foreach ($restockList as $list) {
                if ($users['id'] === $list['request_user_id'] || $decoded->role === "admin") {
                    if ($list['request_user_id']) {
                        $user = $this->Users->getUserId($list['request_user_id']);
                        $list['request_user_id'] = $user['username'];
                    }

                    if ($list['response_user_id']) {
                        $user = $this->Users->getUserId($list['response_user_id']);
                        $list['response_user_id'] = $user['username'];
                    }

                    $restock = array_merge($restock, [$list]);
                }
            }
        }

        if (isset($users['role']) && $users['role'] === 'gudang') {
            foreach ($restockList as $list) {
                if ((!$list['response_user_id'] && $list['status'] == 1) || ($list['response_user_id'] === $users['id'] && $list['status'] >= 1) || ($decoded->role === "admin" && $list['status'] > 1)) {
                    if ($list['request_user_id']) {
                        $user = $this->Users->getUserId($list['request_user_id']);
                        $list['request_user_id'] = $user['username'];
                    }

                    if ($list['response_user_id']) {
                        $user = $this->Users->getUserId($list['response_user_id']);
                        $list['response_user_id'] = $user['username'];
                    }

                    $restock = array_merge($restock, [$list]);
                }
            }
        }

        if (isset($users['role']) && $users['role'] === 'admin') {
            foreach ($restockList as $list) {
                if ($users['id'] === $list['request_user_id'] || $decoded->role === "admin") {
                    if ($list['request_user_id']) {
                        $user = $this->Users->getUserId($list['request_user_id']);
                        $list['request_user_id'] = $user['username'];
                    }

                    if ($list['response_user_id']) {
                        $user = $this->Users->getUserId($list['response_user_id']);
                        $list['response_user_id'] = $user['username'];
                    }

                    $restock = array_merge($restock, [$list]);
                }
            }
        }

        $data = [
            'title' => 'Restock',
            'restock' => $restock,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $this->Pager->getNextPageURI(),
            'backPage' => $this->Pager->getPreviousPageURI()
        ];

        return view('pages/restock/restock_page', $data);
    }

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
            }

            $data = [
                'status' => 1,
                'request_user_id' => $users['id'],
                'response_user_id' => null,
                'message' => $body['message']
            ];
            $rules = $this->Restock->getValidationRules();
            $message = $this->Restock->getValidationMessages();
            unset($rules['restock_code'], $rules['response_user_id']);
            $this->Restock->setValidationRules($rules);

            if (isset($users['id']) != isset($restock['request_user_id'])) {
                $data = array_merge($data, ['request_user_id' => $users['id']]);
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
                'title' => 'Buat permintaan',
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
            unset($rules['response_user_id']);
            $this->Restock->setValidationRules($rules);

            if (!$restock) {
                $data = [
                    'restock_code' => $body['restock'],
                    'status' => 0,
                    'request_user_id' => $users['id'],
                    'response_user_id' => null,
                    'message' => null
                ];

                if ($this->validateData($data, $rules, $message) && $this->Restock->insert($data)) {
                    $restock = $this->Restock->getOneData($body['restock']);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => $validated->listErrors()]);
                }
            }

            if ($restock && $goods) {
                $data = [
                    'goods_id' => $goods['id'],
                    'restock_id' => $restock['id'],
                    'qty' => 1,
                    'qty_send' => 0,
                    'qty_damaged' => 0,
                    'qty_excess' => 0,
                    'qty_less' => 0,
                ];

                if ($restock['status'] == 1) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Silahkan lakukan pembatalan restock terlebih dahulu!']);
                }

                if ($restock['status'] == 2) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Permintaan sedang dalam proses pengiriman!']);
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

        if ($body && isset($body['restock']) && isset($body['goods'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            $goods = $this->Goods->getOneData($body['goods']);
            $rules = $this->GoodsRestock->getValidationRules();
            $message = $this->GoodsRestock->getValidationMessages();

            $data = [
                'goods_id' => $goods['id'],
                'restock_id' => $restock['id'],
                'qty' => $body['qty'],
                'qty_send' => 0,
                'qty_damaged' => 0,
                'qty_excess' => 0,
                'qty_less' => 0,
            ];

            if ($restock['status'] == 1) {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Silahkan lakukan pembatalan restock terlebih dahulu!']);
            }

            if ($restock['status'] == 2) {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Permintaan sedang dalam proses pengiriman!']);
            }

            if ($data['qty'] < 1) {
                $data['qty'] = null;
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Jumlah barang tidak boleh kurang dari 1!']);
            }

            $idGoods = $this->GoodsRestock->checkList($data['restock_id'], $data['goods_id']);

            if (isset($idGoods['qty_send']) && $idGoods['qty_send'] != 0) {
                $data['qty_send'] = $idGoods['qty_send'];
            }

            if ($idGoods['qty'] == $data['qty']) {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Jumlah yang dimasukan sama dengan yang sebelumnya!']);
            }

            if ($this->validateData($data, $rules, $message)) {
                if (($idGoods && isset($idGoods['id'])) && $this->GoodsRestock->update($idGoods['id'], $data)) {
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
                if ($restock['status'] == 1) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Silahkan lakukan pembatalan restock terlebih dahulu!']);
                }

                if ($restock['status'] == 2) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Permintaan sedang dalam proses pengiriman!']);
                }

                $goodsRestock = $this->GoodsRestock->listRestock($restock['id']);
                $goods = $this->Goods->getOneData($body['goods']);
                $id = null;
                $load = 0;
                foreach ($goodsRestock as $list) {
                    $goodsId = $this->Goods->getDataById($list['goods_id']);
                    if ($list['qty_send'] != 0 && $restock['status'] <= 3 && $list['goods_id'] == $goods['id']) {
                        $stock = (int)$goodsId['goods_stock_warehouse'] + (int)$list['qty_send'];
                        $this->Goods->update($goodsId['id'], ['goods_stock_warehouse' => $stock]);
                        $load = 1;
                    }

                    if (!$goods && !$goodsId && $this->GoodsRestock->delete($list['id'])) {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['success' => 'Data barang berhasil dihapus!']);
                    }

                    if ($list['goods_id'] == $goods['id']) {
                        $id = $list['id'];
                    }
                }

                if ($id && $this->GoodsRestock->delete($id)) {
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

        if (!isset($restock)) {
            session()->setFlashdata('errors', 'Data restock tidak ditemukan!');
            return redirect()->back();
        }

        if ($restock['status'] == 1) {
            session()->setFlashdata('errors', 'Silahkan lakukan pembatalan restock terlebih dahulu!');
            return redirect()->back();
        }

        if ($restock['status'] == 2) {
            session()->setFlashdata('errors', 'Permintaan sedang dalam proses pengiriman!');
            return redirect()->back();
        }

        if ($users['id'] === $restock['request_user_id'] || $decoded->role === "admin") {
            $data = [
                'title' => 'Edit permintaan',
                'link' => '/restock',
                'message' => $restock['message'],
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

            if ($restock['status'] == 1 && $decoded->role != 'admin') {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Silahkan lakukan pembatalan restock terlebih dahulu!']);
            }

            if ($restock['status'] == 2 && $decoded->role != 'admin') {
                session()->setFlashdata('errors', 'Permintaan sedang dalam proses pengiriman!');
                return redirect()->back();
            }

            if ($users['id'] === $restock['request_user_id'] || $decoded->role === "admin") {
                $goodsRestock = $this->GoodsRestock->listRestock($restock['id']);
                if ($goodsRestock && $restock['status'] < 2) {
                    $goodsID = [];
                    foreach ($goodsRestock as $list) {
                        $goodsID = array_merge($goodsID, [$list['id']]);
                        if ($list['qty_send'] != 0 && $restock['status'] <= 3) {
                            $goods = $this->Goods->getDataById($list['goods_id']);
                            if ($goods) {
                                $stock = (int)$goods['goods_stock_warehouse'] + (int)$list['qty_send'];
                                $this->Goods->update($goods['id'], ['goods_stock_warehouse' => $stock]);
                            }
                        }
                    }

                    if (!$this->GoodsRestock->delete($goodsID)) {
                        session()->setFlashdata('errors', 'Gagal menghapus data permintaan restock!');
                        return redirect()->back();
                    }
                }

                if (($restock['status'] < 2 && $this->Restock->delete($restock['id'], true)) || ($restock['status'] >= 2 && $this->Restock->delete($restock['id']))) {
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

        if ($body && isset($body['restock'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            if ($restock['status'] != 2) {
                if ($users['id'] === $restock['request_user_id'] || $decoded->role === "admin") {
                    if ($this->Restock->update($restock['id'], ['status' => 0])) {
                        session()->setFlashdata('success', 'Permintaan restock berhasil di batalkan.');
                        return redirect()->back();
                    } else {
                        session()->setFlashdata('errors', 'Permintaan restock gagal di batalkan!');
                        return redirect()->back();
                    }
                } else {
                    session()->setFlashdata('errors', 'Anda tidak dapat membatalkan permintaan restock!');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('errors', 'Permintaan sedang dalam proses pengiriman!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Data permintaan restock tidak ditemukan! ');
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

            $data = [
                'title' => 'Detail permintaan',
                'link' => '/restock',
                'restock' => $restock['restock_code'],
                'message' => $restock['message'],
                'date' => $restock['updated_at'],
                'goods' => $goodsList,
            ];
            return view('pages/restock/restock_details', $data);
        } else {
            session()->setFlashdata('errors', 'Datar restock tidak ditemukan');
            return redirect()->back();
        }
    }

    public function trash()
    {
        $restock = $this->Restock->onlyDeleted()->findAll();
        $setRestock = [];
        foreach ($restock as $list) {
            unset($list['id']);
            $list['request_user_id'] = $this->Users->getUserId($list['request_user_id'])['username'];
            $list['response_user_id'] = $this->Users->getUserId($list['response_user_id'])['username'];
            $setRestock = array_merge($setRestock, [$list]);
        }

        $data = [
            'title' => 'Trash Restock',
            'link' => '/menu',
            'restock' => $setRestock
        ];

        return view('pages/restock/restock_trash', $data);
    }

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
                session()->setFlashdata('success', 'Restock berhasil di kembalikan.');
                return redirect()->back();
            } else {
                session()->setFlashdata('errors', 'Data restock gagal di kembalikan!');
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
            if ($restock && $this->Restock->onlyDeleted()->delete($restock['id'], true)) {
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
                'message' => $restock['message']
            ];
            return view('pages/restock/restock_send', $data);
        } else {
            session()->setFlashdata('errors', 'Data permintaan restock tidak ditemukan!');
            return redirect()->back();
        }
    }


    // Send Restock
    // Json
    function restockList()
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
            foreach ($listRestock as $list) {
                $goods = $this->Goods->getDataById($list['goods_id']);
                $restock = $this->Restock->getDataById($list['restock_id']);
                unset($list['id']);
                unset($list['goods_id']);
                unset($list['restock_id']);
                $list = array_merge($list, ['goods_code' => $goods['goods_code']]);
                $list = array_merge($list, ['goods_name' => $goods['goods_name']]);
                $list = array_merge($list, ['goods_stock_warehouse' => $goods['goods_stock_warehouse']]);
                $list = array_merge($list, ['restock_code' => $restock['restock_code']]);

                $goodsList = array_merge($goodsList, [$list]);
            }
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['data' => $goodsList]);
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Data permintaan restock tidak ditemukan!']);
        }
    }

    public function addSend()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);
        $validated = \Config\Services::validation();

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock']) && isset($body['goods']) && isset($body['qtyItems']) && isset($users)) {
            $restock = $this->Restock->getOneData($body['restock']);
            $goods = $this->Goods->getOneData($body['goods']);
            $value = $body['qtyItems'];
            $rules = [
                'qtyItems' => 'numeric'
            ];
            $message = [
                'qtyItems' => [
                    'numeric' => 'Jumlah yang dimasukan harus berupa angka'
                ]
            ];

            if ($restock && $goods && $this->validateData(['qtyItems' => $value], $rules, $message)) {
                $getGoods = $this->GoodsRestock->checkList($restock['id'], $goods['id']);
                $resultValue = 0;
                $goodsValue = 0;

                if ($body['oprator'] == 'plus') {
                    $resultValue = $value + $getGoods['qty_send'];
                    $goodsValue = $goods['goods_stock_warehouse'] - $value;
                } else {
                    $resultValue = $getGoods['qty_send'] - $value;
                    $goodsValue = $value + $goods['goods_stock_warehouse'];
                }

                if ($resultValue >= 0 && $goodsValue >= 0 && $this->GoodsRestock->update($getGoods['id'], ['qty_send' => $resultValue]) && $this->Goods->update($goods['id'], ['goods_stock_warehouse' => $goodsValue]) && $this->Restock->update($restock['id'], ['status' => 2, 'response_user_id' => $users['id']])) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['success' => "Jumlah barang berhasil diperbaharui."]);
                } else {
                    if ($goodsValue <= 0) {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['errors' => 'Jumlah barang di gundang kurang!']);
                    } else {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['errors' => 'Jumlah barang gagal diperbaharui!']);
                    }
                }
            } else {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => $validated->listErrors()]);
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Data barang restock tidak ditemukan!']);
        }
    }
    // End Json


    public function sendRestock()
    {
        $body = $this->request->getPost();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if (isset($body[csrf_token()]) != csrf_hash()) {
            session()->setFlashdata('errors', 'Permintaan restock gagal dibuat!');
            return redirect()->back();
        }

        if ($body && isset($body['restock_code']) && isset($users)) {
            $restock = $this->Restock->getOneData($body['restock_code']);
            if ($restock) {
                $data = [
                    'status' => 3,
                    'response_user_id' => $users['id']
                ];

                if ($restock && $data && $this->Restock->update($restock['id'], $data)) {
                    session()->setFlashdata('success', 'Pemintaan restock telah dikirim.');
                    return redirect()->to('/restock');
                } else {
                    session()->setFlashdata('errors', 'Permintaan restock gagal dikirim!');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('errors', 'Permintaan restock tidak ditemukan!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Input restock invalid!');
            return redirect()->back();
        }
    }

    public function cancleSend()
    {
        $body = $this->request->getPost();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if (isset($body[csrf_token()]) != csrf_hash()) {
            session()->setFlashdata('errors', 'Permintaan restock gagal dibuat!');
            return redirect()->back();
        }

        if ($body && isset($body['restock_code'])) {
            $restock = $this->Restock->getOneData($body['restock_code']);
            if (($restock && $users['id'] == $restock['response_user_id']) || $users['role'] == 'admin') {
                if ($this->Restock->update($restock['id'], ['status' => 1])) {
                    session()->setFlashdata('success', 'Pegiriman berhasil dibatalkan.');
                    return redirect()->back();
                } else {
                    session()->setFlashdata('errors', 'Pegiriman gagal dibatalkan.');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('errors', 'Data pegiriman tidak ditemukan.');
                return redirect()->back();
            }
        }
    }
}
