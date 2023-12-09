<?php

namespace App\Controllers;

use App\Models\Goods;
use App\Models\Users;
use App\Models\Restock;
use App\Models\GoodsHistory;
use App\Models\GoodsRestock;
use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;

class HistoryController extends BaseController
{
    protected $Users, $Goods, $Restock, $GoodsRestock, $GoodsHistory, $JwtHelpers;
    public function __construct()
    {
        $this->Users = new Users();
        $this->Goods = new Goods();
        $this->Restock = new Restock();
        $this->GoodsHistory = new GoodsHistory();
        $this->GoodsRestock = new GoodsRestock();
        $this->JwtHelpers = new JwtHelpers();
    }

    public function index()
    {
        $data = [
            'title' => 'History',
        ];
        return view('pages/dashboard/history_page', $data);
    }

    public function history()
    {
        $goodsRestock = $this->GoodsRestock->listGoods();
        $setRestock = [];
        foreach ($goodsRestock as $list) {
            $goods = $this->Goods->getDataById($list['goods_id']);
            if (isset($goods['goods_name'])) {
                $list['goods_id'] = $goods['goods_name'];
            } else {
                $list['goods_id'] = 'Tidak ditemukan';
            }
            $restock = $this->Restock->getDataById($list['restock_id']);
            if (isset($restock['restock_code'])) {
                $list['restock_code'] = $restock['restock_code'];
                $users = $this->Users->getUserId($restock['user_id']);
                if (isset($users['username'])) {
                    $list['user_id'] = $users['username'];
                } else {
                    $list['user_id'] = 'Tidak ditemukan';
                }
            } else {
                $list['restock_code'] = 'Tidak ditemukan';
            }
            $list['status'] = 0;
            unset($list['id']);
            unset($list['restocks_id']);
            $setRestock = array_merge($setRestock, [$list]);
        }

        $goodsHistory = $this->GoodsHistory->listGoods();
        $setHistory = [];
        foreach ($goodsHistory as $list) {
            $goods = $this->Goods->getDataById($list['goods_id']);
            if (isset($goods['goods_name'])) {
                $list['goods_id'] = $goods['goods_name'];
                $list['goods_code'] = $goods['goods_code'];
            } else {
                $list['goods_id'] = 'Tidak ditemukan';
                $list['goods_code'] = 'Tidak ditemukan';
            }
            $users = $this->Users->getUserId($list['user_id']);
            if (isset($users['username'])) {
                $list['user_id'] = $users['username'];
            } else {
                $list['user_id'] = 'Tidak ditemukan';
            }
            $list['status'] = 1;
            unset($list['id']);
            $setHistory = array_merge($setHistory, [$list]);
        }

        $setGoods = array_merge($setHistory, $setRestock);

        usort($setGoods, function ($a, $b) {
            $timestampA = strtotime($a['created_at']);
            $timestampB = strtotime($b['created_at']);
            return $timestampB - $timestampA;
        });

        $lengthData = sizeof($setGoods);

        $groups = null;
        if (count($setRestock) >= count($setHistory)) {
            $groups = 'group1';
        } else {
            $groups = 'group2';
        }

        $nextURL = null;
        if ($lengthData != 0) {
            $nextURL = $this->Pager->getNextPageURI($groups);
        }

        $perPage = $this->Pager->getPerPage('groups1') + $this->Pager->getPerPage('groups2');
        $total = $this->Pager->getTotal('group1') + $this->Pager->getTotal('group2');
        $data = [
            'goods' => $setGoods,
            'currentPage' => $this->Pager->getCurrentPage($groups),
            'pageCount'  => $this->Pager->getPageCount($groups),
            'perPage' => $perPage,
            'totalItems' => $total,
            'nextPage' => $nextURL,
            'backPage' => $this->Pager->getPreviousPageURI($groups)
        ];

        $this->response->setContentType('application/json');
        return $this->response->setJSON($data);
    }

    public function getDate()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['search'])) {
            $goodsRestock = $this->GoodsRestock->searchListGoods($body['search']);
            $setRestock = [];
            foreach ($goodsRestock as $list) {
                $goods = $this->Goods->getDataById($list['goods_id']);
                if (isset($goods['goods_name'])) {
                    $list['goods_id'] = $goods['goods_name'];
                } else {
                    $list['goods_id'] = 'Tidak ditemukan';
                }
                $restock = $this->Restock->getDataById($list['restock_id']);
                if (isset($restock['restock_code'])) {
                    $list['restock_code'] = $restock['restock_code'];
                    $users = $this->Users->getUserId($restock['user_id']);
                    if (isset($users['username'])) {
                        $list['user_id'] = $users['username'];
                    } else {
                        $list['user_id'] = 'Tidak ditemukan';
                    }
                } else {
                    $list['restock_code'] = 'Tidak ditemukan';
                }
                $list['status'] = 0;
                unset($list['id']);
                unset($list['restocks_id']);
                $setRestock = array_merge($setRestock, [$list]);
            }

            $goodsHistory = $this->GoodsHistory->searchListGoods($body['search']);
            $setHistory = [];
            foreach ($goodsHistory as $list) {
                $goods = $this->Goods->getDataById($list['goods_id']);
                if (isset($goods['goods_name'])) {
                    $list['goods_id'] = $goods['goods_name'];
                    $list['goods_code'] = $goods['goods_code'];
                } else {
                    $list['goods_id'] = 'Tidak ditemukan';
                    $list['goods_code'] = 'Tidak ditemukan';
                }
                $users = $this->Users->getUserId($list['user_id']);
                if (isset($users['username'])) {
                    $list['user_id'] = $users['username'];
                } else {
                    $list['user_id'] = 'Tidak ditemukan';
                }
                $list['status'] = 1;
                unset($list['id']);
                $setHistory = array_merge($setHistory, [$list]);
            }

            $setGoods = array_merge($setHistory, $setRestock);

            usort($setGoods, function ($a, $b) {
                $timestampA = strtotime($a['created_at']);
                $timestampB = strtotime($b['created_at']);
                return $timestampB - $timestampA;
            });

            $data = [
                'goods' => $setGoods
            ];
            $this->response->setContentType('application/json');
            return $this->response->setJSON($data);
        } else {
            $this->response->setContentType('application/json');
            return $this->response->setJSON(['errors' => 'History!']);
        }
    }
}
