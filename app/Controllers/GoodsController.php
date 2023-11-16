<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;
use App\Models\Goods;
use App\Models\Users;
use CodeIgniter\I18n\Time;

class GoodsController extends BaseController
{
    protected $Goods, $Users, $JwtHelpers;
    public function __construct()
    {
        $this->Goods = new Goods();
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
    }
    public function index()
    {

        $getGoods = $this->Goods->getPaginate();
        $setGoods = [];

        foreach ($getGoods as $goods) {
            unset($goods['users_id']);
            $setGoods = array_merge($setGoods, [$goods]);
        }
        $data = [
            'title' => 'Barang',
            'goods' => $setGoods,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $this->Pager->getNextPageURI(),
            'backPage' => $this->Pager->getPreviousPageURI(),
        ];

        return view('pages/goods/goods_page', $data);
    }

    // Json Response
    public function goodsList()
    {
        $lengthData = sizeof($this->Goods->getPaginate());
        $nextURL = null;
        if ($lengthData != 0) {
            $nextURL = $this->Pager->getNextPageURI();
        }

        $getGoods = $this->Goods->getPaginate();
        $setGoods = [];
        foreach ($getGoods as $goods) {
            unset($goods['id']);
            unset($goods['users_id']);
            $setGoods = array_merge($setGoods, [$goods]);
        }

        $data = [
            'goods' => $setGoods,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $nextURL,
            'backPage' => $this->Pager->getPreviousPageURI(),
        ];

        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }

    public function goodsSearch()
    {
        $requestBody = $this->request->getBody();
        $jsonData = json_decode($requestBody, true);

        $getGoods = $this->Goods->search($jsonData['search']);
        $setGoods = [];
        foreach ($getGoods as $goods) {
            unset($goods['id']);
            unset($goods['users_id']);
            $setGoods = array_merge($setGoods, [$goods]);
        }

        $data = [
            'goods' => $setGoods,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $this->Pager->getNextPageURI(),
            'backPage' => $this->Pager->getPreviousPageURI(),
        ];
        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }
    // End Json Response

    public function create()
    {
        $body = $this->request->getPost();
        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        if ($body && isset($decoded->username)) {
            if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
                $body = null;
                session()->setFlashdata('errors', 'Barang gagal ditambahkan!');
                return redirect()->back();
            }

            $prepPrice = ['goods_prev_price' => 0];
            $body = array_merge($body, $prepPrice);
            $uniqueCode = ['goods_code' => $this->Goods->uniqueCode()];
            $body = array_merge($body, $uniqueCode);
            $users = $this->Users->getUser($decoded->username);
            $body['users_id'] = $users['id'];
            unset($decoded->username);

            if (!$this->validateData($body, $this->Goods->getValidationRules(), $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $this->Goods->insert([
                    'goods_code' => $body['goods_code'],
                    'goods_name' => $body['goods_name'],
                    'goods_price' => $body['goods_price'],
                    'goods_prev_price' => $body['goods_prev_price'],
                    'goods_stock_shop' => $body['goods_stock_shop'],
                    'goods_stock_warehouse' => $body['goods_stock_warehouse'],
                    'goods_min_stock' => $body['goods_min_stock'],
                    'users_id' => $body['users_id']
                ]);
                session()->setFlashdata('success', 'Barang berhasil di tambahkan');
                return redirect()->to('/goods');
            }
        } else {
            $data = [
                'title' => 'Tambah Data Barang',
                'link' => '/goods'
            ];
            return view('pages/goods/goods_create', $data);
        }
    }

    public function edit($slug)
    {
        $goods = $this->Goods->getOneData($slug);
        unset($goods['id']);
        $goods['created_at'] = Time::parse($goods['created_at'], 'Asia/Jakarta', 'id-ID')->humanize();
        $goods['updated_at'] = Time::parse($goods['updated_at'], 'Asia/Jakarta', 'id-ID')->humanize();
        $users = $this->Users->getUserId($goods['users_id']);
        $goods['goods_users'] = $users['username'];

        $data = [
            'title' => "Edit Data Barang",
            'link' => '/goods',
            'goods' => $goods,
        ];

        return view('pages/goods/goods_edit', $data);
    }

    public function update()
    {
        $body = $this->request->getPost();
        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);

        if ($body && isset($body['goods_code']) && isset($decoded->username)) {
            $goods = $this->Goods->getOneData($body['goods_code']);
            $users = $this->Users->getUser($decoded->username);
            $body = array_merge($body, ['users_id' => $users['id']]);
            unset($body['goods_code']);
            unset($decoded->username);
            if ($body) {
                if ($goods['goods_price'] != $body['goods_price']) {
                    $body += ['goods_prev_price' => $goods['goods_price']];
                } else {
                    $body += ['goods_prev_price' => 0];
                }
            }

            $rules = $this->Goods->getValidationRules();
            unset($rules['goods_stock_shop']);
            unset($rules['goods_stock_warehouse']);

            if (!$this->validateData($body, $rules, $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $data = [
                    'goods_name' => $body['goods_name'],
                    'goods_price' => $body['goods_price'],
                    'goods_prev_price' => $body['goods_prev_price'],
                    'goods_min_stock' => $body['goods_min_stock'],
                    'users_id' => $body['users_id']
                ];

                $this->Goods->update($goods['id'], $data);
                session()->setFlashdata('success', 'Barang berhasil di update');
                return redirect()->to('/goods');
            }
        } else {
            session()->setFlashdata('errors', 'Barang yang akan di update tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function updateStock()
    {
        $body = $this->request->getPost();
        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        $session = session()->get('sessionData');
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);

        if ($body && isset($body['goods_code']) && isset($decoded->username)) {
            $goods = $this->Goods->getOneData($body['goods_code']);
            $users = $this->Users->getUser($decoded->username);
            $body = array_merge($body, ['users_id' => $users['id']]);
            unset($body['goods_code']);

            $rules = $this->Goods->getValidationRules();
            unset($rules['goods_name']);
            unset($rules['goods_price']);
            unset($rules['goods_prev_price']);
            unset($rules['goods_min_stock']);

            if (!$this->validateData($body, $rules, $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $data = [
                    'goods_stock_shop' => $body['goods_stock_shop'],
                    'goods_stock_warehouse' => $body['goods_stock_warehouse'],
                    'users_id' => $body['users_id']
                ];

                $this->Goods->update($goods['id'], $data);
                session()->setFlashdata('success', 'Barang berhasil di update');
                return redirect()->to('/goods');
            }
        } else {
            session()->setFlashdata('errors', 'Stok barang yang akan di update tidak di temukan!');
            return redirect()->back();
        }
    }

    public function delete()
    {
        $body = $this->request->getPost();

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['goods_code'])) {
            $goods = $this->Goods->getOneData($body['goods_code']);
            $this->Goods->delete($goods['id']);
            session()->setFlashdata('success', 'Barang berhasil di hapus');
            return redirect()->to('/goods');
        } else {
            session()->setFlashdata('errors', 'Barang tidak ditemukan!');
            return redirect()->back();
        }
    }
}
