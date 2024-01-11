<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;
use App\Models\GoodsHistory;
use App\Models\GoodsRestock;
use App\Models\Restock;
use App\Models\Users;

class DashboardController extends BaseController
{

    protected $Users, $Goods, $Restock, $GoodsRestock, $GoodsHistory;
    public function __construct()
    {
        $this->Users = new Users();
        $this->Goods = new Goods();
        $this->Restock = new Restock();
        $this->GoodsHistory = new GoodsHistory();
        $this->GoodsRestock = new GoodsRestock();
    }

    public function index()
    {
        $date = date('Y-m-d');
        $goodsIn = $this->GoodsHistory->like('created_at', $date)->selectSum('qty')->findAll();
        $goodsOut = $this->GoodsRestock->like('updated_at', $date)->selectSum('qty')->findAll();
        $restock = $this->Restock->like('updated_at', $date)->findAll();
        $goods = $this->Goods->findAll();
        $setGoods = [];
        foreach ($goods as $list) {
            $users = $this->Users->getUserId($list['users_id']);
            $list['user_id'] = $users['username'];
            unset($list['id']);
            if ($list['goods_stock_warehouse'] < $list['goods_min_stock']) {
                $setGoods = array_merge($setGoods, [$list]);
            }
        }

        return view('pages/dashboard/dashboard_page', [
            'title' => 'Dashboard',
            'goods_in' => $goodsIn[0]['qty'] != '' ? $goodsIn[0]['qty'] : 0,
            'goods_out' => $goodsOut[0]['qty'] != '' ? $goodsOut[0]['qty'] : 0,
            'restock' => count($restock),
            'goods_low' => count($setGoods),
            'goods_qty' => count($goods)
        ]);
    }

    public function history()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        $date = date('Y-m-d', strtotime('-30 day'));
        if ($body && isset($body['date'])) {
            $date = date('Y-m-d', strtotime($body['date'].' -30 day'));
        }

        $goodsHistory = $this->GoodsHistory->where('created_at >=', $date)->orderBy('created_at', 'ASC')->findAll();
        $setGoods = [];
        foreach ($goodsHistory as $list1) {
            $key = date('Y-m-d', strtotime($list1['created_at']));
            $found = false;

            foreach ($setGoods as &$list2) {
                if ($list2['name'] == $key) {
                    $list2['qty'] += $list1['qty'];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $setGoods[] = [
                    'name' => $key,
                    'qty' => $list1['qty'],
                ];
            }
        }

        $goodsRestock = $this->GoodsRestock->where('updated_at >=', $date)->orderBy('updated_at', 'ASC')->findAll();
        $setRestock = [];
        foreach ($goodsRestock as $list1) {
            $key = date('Y-m-d', strtotime($list1['created_at']));
            $found = false;

            foreach ($setRestock as &$list2) {
                if ($list2['name'] == $key) {
                    $list2['qty'] += $list1['qty'];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $setRestock[] = [
                    'name' => $key,
                    'qty' => $list1['qty'],
                ];
            }
        }

        $this->response->setContentType('application/json');
        return $this->response->setJSON(['goodsHistory' => $setGoods, 'goodsRestock' => $setRestock]);
    }

    public function getGoodsInOut()
    {
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        $requestBody = $this->request->getBody();
        $body = json_decode($requestBody, true);

        if ($csrfToken != csrf_hash()) {
            $body = null;
        }

        $date = date('Y-m-d');
        if ($body && isset($body['date'])) {
            $date = date('Y-m-d', strtotime($body['date']));
        }

        $goodsIn = $this->GoodsHistory->like('created_at', $date)->orderBy('qty', 'DESC')->findAll();
        $GoodsIn = [];
        foreach ($goodsIn as $list) {
            $goods_id = $list['goods_id'];
            $goods_name = $this->Goods->getDataById($goods_id);

            if (isset($GoodsIn[$goods_id])) {
                $GoodsIn[$goods_id]['qty'] = $GoodsIn[$goods_id]['qty'] + $list['qty'];
            } else {
                $GoodsIn[$goods_id]['id'] = $goods_id;
                if ($goods_name) {
                    $GoodsIn[$goods_id]['name'] = $goods_name['goods_name'];
                } else {
                    $GoodsIn[$goods_id]['name'] = 'Tidak ditemukan';
                }
                $GoodsIn[$goods_id]['qty'] = $list['qty'];
            }
        }
        $newGoodsIn = array_map(function ($item) {
            $data = [
                'name' => $item['name'],
                'qty' => $item['qty']
            ];
            return $data;
        }, $GoodsIn);
        $GoodsIn = array_values($newGoodsIn);

        $goodsOut = $this->GoodsRestock->like('updated_at', $date)->orderBy('qty', 'DESC')->findAll();
        $GoodsOut = [];
        foreach ($goodsOut as $list) {
            $goods_id = $list['goods_id'];
            $goods_name = $this->Goods->getDataById($goods_id);

            if (isset($GoodsOut[$goods_id])) {
                $GoodsOut[$goods_id]['qty'] = $GoodsOut[$goods_id]['qty'] + $list['qty'];
            } else {
                $GoodsOut[$goods_id]['id'] = $goods_id;
                if ($goods_name) {
                    $GoodsOut[$goods_id]['name'] = $goods_name['goods_name'];
                } else {
                    $GoodsOut[$goods_id]['name'] = 'Tidak ditemukan';
                }
                $GoodsOut[$goods_id]['qty'] = $list['qty'];
            }
        }
        $newGoodsOut = array_map(function ($item) {
            $data = [
                'name' => $item['name'],
                'qty' => $item['qty']
            ];
            return $data;
        }, $GoodsOut);
        $GoodsOut = array_values($newGoodsOut);

        $this->response->setContentType('application/json');
        return $this->response->setJSON(['goodsIn' => $GoodsIn, 'goodsOut' => $GoodsOut]);
    }

    public function trash()
    {
        return view('pages/dashboard/trash_page', [
            'title' => 'Trash'
        ]);
    }
}
