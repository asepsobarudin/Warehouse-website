<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Goods;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;

class GoodsController extends BaseController
{
    protected $Goods;
    public function __construct()
    {
        $this->Goods = new Goods();
    }
    public function index()
    {
        $pager = \Config\Services::pager();
        $data = [
            'title' => 'Goods',
            'goods' => $this->Goods->getAll(),
            'currentPage' => $pager->getCurrentPage(),
            'pageCount'  => $pager->getPageCount(),
            'totalItems' => $pager->getTotal(),
            'nextPage' => $pager->getNextPageURI(),
            'backPage' => $pager->getPreviousPageURI(),
        ];

        return view('pages/all/goods_page', $data);
    }

    public function detail($slug)
    {
        $goods = $this->Goods->getOneData($slug);
        unset($goods['id']);
        $data = [
            'title' => 'Details',
            'goods' => $goods
        ];
        return view('pages/all/goods_detail', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($data) {
            if ($data) {
                $prepPrice = ['goods_prev_price' => 0];
                $data = array_merge($data, $prepPrice);
            }

            $uniqueCode = ['goods_code' => $this->Goods->uniqueCode()];
            $data = array_merge($data, $uniqueCode);

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
                ]);
                session()->setFlashdata('success', 'Barang berhasil di tambahkan');
                return redirect()->to('/goods');
            }
        } else {
            $data = [
                'title' => 'Create New Goods',
                'link' => '/goods'
            ];
            return view('pages/all/goods_create', $data);
        }
    }

    public function edit($slug)
    {
        $goods = $this->Goods->getOneData($slug);
        unset($goods['id']);
        $goods['created_at'] = Time::parse($goods['created_at'], 'Asia/Jakarta', 'id-ID')->humanize();
        $goods['updated_at'] = Time::parse($goods['updated_at'], 'Asia/Jakarta', 'id-ID')->humanize();

        $data = [
            'title' => "Edit Goods",
            'link' => '/goods',
            'goods' => $goods,
        ];

        return view('pages/all/goods_update', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();
        $goods = $this->Goods->getOneData($data['goods_code']);
        unset($data['goods_code']);
        if ($data) {
            if ($goods['goods_price'] != $data['goods_price']) {
                $data += ['goods_prev_price' => $goods['goods_price']];
            } else {
                $data += ['goods_prev_price' => 0];
            }
        }

        if (!$this->validateData($data, $this->Goods->getValidationRules(), $this->Goods->getValidationMessages())) {
            return redirect()->back()->withInput();
        } else {
            $data = [
                'goods_name' => $data['goods_name'],
                'goods_price' => $data['goods_price'],
                'goods_prev_price' => $data['goods_prev_price'],
                'goods_stok_toko' => $data['goods_stok_toko'],
                'goods_stok_gudang' => $data['goods_stok_gudang'],
                'goods_min_stok' => $data['goods_min_stok'],
            ];

            $this->Goods->update($goods['id'], $data);
            session()->setFlashdata('success', 'Barang berhasil di update');
            return redirect()->to('/goods');
        }
    }

    public function delete()
    {
        $data = $this->request->getPost();
        $goods = $this->Goods->getOneData($data['delete_code']);
        $this->Goods->delete($goods['id']);
        session()->setFlashdata('success', 'Barang berhasil di hapus');
        return redirect()->to('/goods');
    }
}
