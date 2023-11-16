<?php

namespace App\Controllers;

use App\Models\Goods;
use App\Models\Users;
use App\Models\Restock;
use App\Models\GoodsRestock;
use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;

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

            $data = [
                'status' => '1',
                'message' => $body['message']
            ];

            if ($users['id'] != $restock['request_user_id']) {
                $data = array_merge($data, ['request_user_id' => $users['id']]);
            }

            if ($restock && $this->Restock->update($restock['id'], $data)) {
                session()->setFlashdata('success', 'Permintaan restock berhasil dibuat');
                return redirect()->to('restock');
            } else {
                session()->setFlashdata('errors', 'Permintaan restock gagal dibuat!');
                return redirect()->back();
            }
        } else {
            $data = [
                'title' => 'Buat Permintaan Barang',
                'link' => '/restock',
                'restock_code' => $this->Restock->uniqueCode()
            ];
            return view('pages/restock/restock_create', $data);
        }
    }

    public function addGoods()
    {
        $requestBody = $this->request->getBody();
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $body = json_decode($requestBody, true);
        $session = $this->SessionHelpers->getSession();

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        if ($body && isset($body['restock'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            $users = $this->Users->getUser($decoded->username);
            $goods = $this->Goods->getOneData($body['goods']);
            $rules = $this->Restock->getValidationRules();
            $rules = array_merge($rules, ['request_user_id' => 'required']);
            $message = $this->Restock->getValidationMessages();
            $message = array_merge($message, [
                'request_user_id' => [
                    'required' => 'User pembuat permintaan tidak boleh kosong!'
                ]
            ]);

            if (!$restock) {
                $data = [
                    'restock_code' => $body['restock'],
                    'status' => '0',
                    'request_user_id' => $users['id'],
                    'response_user_id' => null,
                    'message' => null
                ];

                if (!$this->validateData($data, $rules, $message)) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Penambahan barang gagal dilakukan!']);
                } else {
                    if ($this->Restock->insert($data)) {
                        $restock = $this->Restock->getOneData($body['restock']);
                    } else {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['errors' => 'Penambahan barang gagal dilakukan!']);
                    }
                }
            }

            if ($restock && $goods) {
                $data = [
                    'goods_id' => $goods['id'],
                    'restock_id' => $restock['id'],
                    'qty' => 1
                ];

                $rules = $this->GoodsRestock->getValidationRules();
                $message = $this->GoodsRestock->getValidationMessages();
                if (!$this->validateData($data, $rules, $message)) {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Penambahan barang gagal dilakukan!']);
                } else {
                    if (!$this->GoodsRestock->checkList($data['restock_id'], $data['goods_id'])) {
                        if ($this->GoodsRestock->insert($data)) {
                            $listRestock = $this->GoodsRestock->listRestock($data['restock_id']);
                            $goodsList = [];
                            foreach ($listRestock as $list) {
                                $goods = $this->Goods->getDataById($list['goods_id']);
                                $restock = $this->Restock->getDataById($list['restock_id']);
                                unset($list['id']);
                                unset($list['goods_id']);
                                unset($list['restock_id']);
                                $list = array_merge($list, ['goods_code' => $goods['goods_code']]);
                                $list = array_merge($list, ['goods_name' => $goods['goods_name']]);
                                $list = array_merge($list, ['restock_code' => $restock['restock_code']]);
                                $goodsList = array_merge($goodsList, [$list]);
                            }
                            $this->response->setContentType('application/json');
                            return $this->response->setJSON(['data' => $goodsList, 'success' => 'Barang berhasil ditambahkan.']);
                        } else {
                            $this->response->setContentType('application/json');
                            return $this->response->setJSON(['errors' => 'Penambahan barang gagal dilakukan!']);
                        }
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
        $requestBody = $this->request->getBody();
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
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
                $list = array_merge($list, ['restock_code' => $restock['restock_code']]);
                $goodsList = array_merge($goodsList, [$list]);
            }
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['data' => $goodsList]);
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'List barang restock tidak ditemukan!']);
        }
    }

    public function addQty()
    {
        $requestBody = $this->request->getBody();
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock']) && isset($body['goods'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            $goods = $this->Goods->getOneData($body['goods']);
            $data = [
                'goods_id' => $goods['id'],
                'restock_id' => $restock['id'],
                'qty' => $body['qty']
            ];

            if ($data['qty'] < 1) {
                $data['qty'] = null;
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Jumlah barang tidak boleh kurang dari 1!']);
            }

            $rules = $this->GoodsRestock->getValidationRules();
            $message = $this->GoodsRestock->getValidationMessages();
            if (!$this->validateData($data, $rules, $message)) {
                $this->response->setContentType('application/json');
                return $this->response->setJSON(['errors' => 'Jumlah barang gagal diubah!']);
            } else {
                $idGoods = $this->GoodsRestock->checkList($data['restock_id'], $data['goods_id']);
                if ($idGoods && isset($idGoods['id'])) {
                    $this->GoodsRestock->update($idGoods['id'], $data);
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['success' => 'Jumlah barang berhasil diubah!']);
                } else {
                    $this->response->setContentType('application/json');
                    return $this->response->setJSON(['errors' => 'Jumlah barang gagal untuk diubah!']);
                }
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Jumlah barang gagal untuk diubah!']);
        }
    }

    public function deleteGoods()
    {
        $requestBody = $this->request->getBody();
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['restock']) && isset($body['goods'])) {
            $restock = $this->Restock->getOneData($body['restock']);
            if ($restock) {
                $goodsRestock = $this->GoodsRestock->listRestock($restock['id']);
                $goods = $this->Goods->getOneData($body['goods']);
                $id = null;
                foreach ($goodsRestock as $list) {
                    if ($list['goods_id'] == $goods['id']) {
                        $id = $list['id'];
                    }
                }

                $length = sizeof($goodsRestock = $this->GoodsRestock->listRestock($restock['id']));

                if ($id && $this->GoodsRestock->delete($id)) {
                    $length = sizeof($goodsRestock = $this->GoodsRestock->listRestock($restock['id']));
                    if ($length < 1 && $this->Restock->update($restock['id'], ['status' => 0])) {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['success' => 'Barang berhasil dihapus!']);
                    } else {
                        $this->response->setContentType('application/json');
                        return $this->response->setJSON(['success' => 'Barang berhasil dihapus!']);
                    }
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

    public function edit($code)
    {
        $restock = $this->Restock->getOneData($code);
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if ($restock['status'] != 2) {
            if ($users['id'] === $restock['request_user_id'] || $decoded->role === "admin") {
                $data = [
                    'title' => 'Edit Permintaan Barang',
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
        } else {
            session()->setFlashdata('errors', 'Permintaan sedang dalam proses pengiriman!');
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
            if ($restock['status'] != 2) {
                if ($users['id'] === $restock['request_user_id'] || $decoded->role === "admin") {
                    $goodsRestock = $this->GoodsRestock->listRestock($restock['id']);
                    if ($goodsRestock) {
                        foreach ($goodsRestock as $list) {
                            $this->GoodsRestock->delete($list['id']);
                        }
                    }

                    if ($this->Restock->delete($restock['id'])) {
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
                session()->setFlashdata('errors', 'Permintaan sedang dalam proses pengiriman!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Data permintaan restock tidak ditemukan! ');
            return redirect()->back();
        }
    }
}
