<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;
use App\Helpers\SessionHelpers;
use App\Models\Goods;
use App\Models\GoodsRestock;
use App\Models\Restock;
use App\Models\Users;

class DistributionController extends BaseController
{
    protected $Restock, $GoodsRestock, $Goods, $Users;
    protected $JwtHelpers, $SessionHelpers;
    public function __construct()
    {
        $this->Restock = new Restock();
        $this->GoodsRestock = new GoodsRestock();
        $this->Goods = new Goods();
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
        $this->SessionHelpers = new SessionHelpers();
    }

    public function index()
    {
        $restockList = $this->Restock->getPaginate();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);
        $restock = [];
        foreach ($restockList as $list) {
            if ((!$list['response_user_id'] && $list['status'] == 1) || $list['response_user_id'] === $users['id'] || ($decoded->role === "admin" && $list['status'] == 1)) {
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
            'title' => 'Distribusi',
            'restock' => $restock,
            'currentPage' => $this->Pager->getCurrentPage(),
            'pageCount'  => $this->Pager->getPageCount(),
            'totalItems' => $this->Pager->getTotal(),
            'nextPage' => $this->Pager->getNextPageURI(),
            'backPage' => $this->Pager->getPreviousPageURI()
        ];
        return view('pages/distribution/distribution_page', $data);
    }

    public function getRestock($code)
    {
        $restock = $this->Restock->getOneData($code);
        if ($restock) {
            $data = [
                'title' => 'List Permintaan Barang',
                'link' => 'distribution',
                'restock_code' => $restock['restock_code'],
                'restock_status' => $restock['status']
            ];
            return view('pages/distribution/distribution_response', $data);
        } else {
            session()->setFlashdata('errors', 'Data permintaan restock tidak ditemukan!');
            return redirect()->back();
        }
    }

    function restockList()
    {
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && $body['restock']) {
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

    public function addItems()
    {
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        $value = $body['qtyItems'];
        if ($body && isset($body['restock']) && isset($body['goods']) && isset($value)) {
            $restock = $this->Restock->getOneData($body['restock']);
            $goods = $this->Goods->getOneData($body['goods']);
            if ($restock && $goods) {
                $getGoods = $this->GoodsRestock->checkList($restock['id'], $goods['id']);

                $resultValue = 0;
                $goodsValue = 0;

                if ($body['oprator'] == 'plus') {
                    $resultValue = $value + $getGoods['qty_response'];
                    $goodsValue = $goods['goods_stock_warehouse'] - $value;
                } else {
                    $resultValue = $getGoods['qty_response'] - $value;
                    $goodsValue = $value + $goods['goods_stock_warehouse'];
                }

                if ($resultValue >= 0 && $goodsValue >= 0 && $this->GoodsRestock->update($getGoods['id'], ['qty_response' => $resultValue]) && $this->Goods->update($goods['id'], ['goods_stock_warehouse' => $goodsValue])) {
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
            }
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'Data barang restock tidak ditemukan!']);
        }
    }

    public function sendRestock()
    {
        $body = $this->request->getPost();
        $session = $this->SessionHelpers->getSession();
        $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
        $users = $this->Users->getUser($decoded->username);

        if (isset($body[csrf_token()]) != csrf_hash()) {
            $body = null;
            session()->setFlashdata('errors', 'Permintaan restock gagal dibuat!');
            return redirect()->back();
        }

        if ($body) {
            $restock = $this->Restock->getOneData($body['restock_code']);
            if ($restock) {
                $data = [
                    'status' => 2,
                    'response_user_id' => $users['id']
                ];

                if ($restock && $data && $this->Restock->update($restock['id'], $data)) {
                    session()->setFlashdata('success', 'Pemintaan restock telah dikirim.');
                    return redirect()->to('/distribution');
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
}
