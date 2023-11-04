<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;
use App\Models\Users;
use CodeIgniter\I18n\Time;

class GoodsController extends BaseController
{
    protected $Goods;
    protected $Users;
    public function __construct()
    {
        $this->Goods = new Goods();
        $this->Users = new Users();
    }
    public function index()
    {
        $pager = \Config\Services::pager();

        $getGoods = $this->Goods->getPaginate();
        $setGoods = [];

        foreach ($getGoods as $goods) {
            $users = $this->Users->getUserId($goods['users_id']);
            $goods['users_id'] = $users['username'];
            $setGoods = array_merge($setGoods, [$goods]);
        }
        $data = [
            'title' => 'Barang',
            'goods' => $setGoods,
            'currentPage' => $pager->getCurrentPage(),
            'pageCount'  => $pager->getPageCount(),
            'totalItems' => $pager->getTotal(),
            'nextPage' => $pager->getNextPageURI(),
            'backPage' => $pager->getPreviousPageURI(),
        ];

        return view('pages/goods/goods_page', $data);
    }

    public function detail($slug)
    {
        $goods = $this->Goods->getOneData($slug);
        unset($goods['id']);
        $data = [
            'title' => 'Details',
            'goods' => $goods
        ];
        return view('pages/goods/goods_detail', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($data && isset($data['username'])) {

            $prepPrice = ['goods_prev_price' => 0];
            $data = array_merge($data, $prepPrice);
            $uniqueCode = ['goods_code' => $this->Goods->uniqueCode()];
            $data = array_merge($data, $uniqueCode);
            $users = $this->Users->getUser($data['username']);
            $data['users_id'] = $users['id'];
            unset($data['username']);

            if (!$this->validateData($data, $this->Goods->getValidationRules(), $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $this->Goods->insert([
                    'goods_code' => $data['goods_code'],
                    'goods_name' => $data['goods_name'],
                    'goods_price' => $data['goods_price'],
                    'goods_prev_price' => $data['goods_prev_price'],
                    'goods_stok_toko' => $data['goods_stok_toko'],
                    'goods_stok_gudang' => $data['goods_stok_gudang'],
                    'goods_min_stok' => $data['goods_min_stok'],
                    'users_id' => $data['users_id']
                ]);
                session()->setFlashdata('success', 'Barang berhasil di tambahkan');
                return redirect()->to('/goods');
            }
        } else {
            $data = [
                'title' => 'Create New Goods',
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
            'title' => "Edit Goods",
            'link' => '/goods',
            'goods' => $goods,
        ];

        return view('pages/goods/goods_update', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        if ($data && isset($data['goods_code']) && isset($data['username'])) {
            $goods = $this->Goods->getOneData($data['goods_code']);
            $users = $this->Users->getUser($data['username']);
            $data = array_merge($data, ['users_id' => $users['id']]);
            unset($data['goods_code']);
            unset($data['username']);
            if ($data) {
                if ($goods['goods_price'] != $data['goods_price']) {
                    $data += ['goods_prev_price' => $goods['goods_price']];
                } else {
                    $data += ['goods_prev_price' => 0];
                }
            }

            $rules = $this->Goods->getValidationRules();
            unset($rules['goods_stok_toko']);
            unset($rules['goods_stok_gudang']);

            if (!$this->validateData($data, $rules, $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $data = [
                    'goods_name' => $data['goods_name'],
                    'goods_price' => $data['goods_price'],
                    'goods_prev_price' => $data['goods_prev_price'],
                    'goods_min_stok' => $data['goods_min_stok'],
                    'users_id' => $data['users_id']
                ];

                $this->Goods->update($goods['id'], $data);
                session()->setFlashdata('success', 'Barang berhasil di update');
                return redirect()->to('/goods');
            }
        } else {
            session()->setFlashdata('failed', 'Barang yang akan di update tidak ditemukan!');
            return redirect()->to('/goods');
        }
    }

    public function updateStock()
    {
        $data = $this->request->getPost();
        if ($data && isset($data['goods_code']) && $data['username']) {
            $goods = $this->Goods->getOneData($data['goods_code']);
            $users = $this->Users->getUser($data['username']);
            $data = array_merge($data, ['users_id' => $users['id']]);
            unset($data['goods_code']);

            $rules = $this->Goods->getValidationRules();
            unset($rules['goods_name']);
            unset($rules['goods_price']);
            unset($rules['goods_prev_price']);
            unset($rules['goods_min_stok']);

            if (!$this->validateData($data, $rules, $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $data = [
                    'goods_stok_toko' => $data['goods_stok_toko'],
                    'goods_stok_gudang' => $data['goods_stok_gudang'],
                    'users_id' => $data['users_id']
                ];

                $this->Goods->update($goods['id'], $data);
                session()->setFlashdata('success', 'Barang berhasil di update');
                return redirect()->to('/goods');
            }
        } else {
            session()->setFlashdata('failed', 'Stok barang yang akan di update tidak di temukan!');
            return redirect()->to('/goods');
        }
    }

    public function delete()
    {
        $data = $this->request->getPost();
        if ($data && isset($data['goods_code'])) {
            $goods = $this->Goods->getOneData($data['goods_code']);
            $this->Goods->delete($goods['id']);
            session()->setFlashdata('success', 'Barang berhasil di hapus');
            return redirect()->to('/goods');
        } else {
            session()->setFlashdata('failed', 'Barang tidak ditemukan!');
            return redirect()->to('/goods');
        }
    }
}
