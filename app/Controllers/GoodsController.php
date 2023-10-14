<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Goods;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;

class GoodsController extends BaseController
{
    protected $Goods, $Category;
    public function __construct()
    {
        $this->Goods = new Goods();
        $this->Category = new Category();
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
        $category = $this->Category->getCategoryById($goods['goods_category']);
        $goods['goods_category'] = $category['category_name'];
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
                if ($data['goods_category'] == 0) {
                    $data['goods_category'] = "";
                }

                if ($data['goods_category'] != "") {
                    $category = $this->Category->getCategory($data['goods_category']);
                    $data['goods_category'] = $category['id'];
                }

                if ($data['goods_stok'] == "") {
                    $data['goods_stok'] = "0";
                }
            }

            $uniqueCode = ['goods_code' => $this->Goods->uniqueCode()];
            $data = array_merge($data, $uniqueCode);

            if (!$this->validateData($data, $this->Goods->getValidationRules(), $this->Goods->getValidationMessages())) {
                return redirect()->back()->withInput();
            } else {
                $imagesName = "dummyimages.jpg";
                $images = $this->request->getFile('goods_images');

                if ($images->isValid()) {
                    $randomName = $images->getRandomName();
                    $images->move('assets/images/uploads', $randomName);
                    $imagesName = $images->getName();
                }

                $this->Goods->insert([
                    'goods_category' => $data['goods_category'],
                    'goods_code' => $data['goods_code'],
                    'goods_name' => $data['goods_name'],
                    'goods_description' => $data['goods_description'],
                    'goods_price' => $data['goods_price'],
                    'goods_prev_price' => "0",
                    'goods_stok' => $data['goods_stok'],
                    'goods_min_stok' => "0",
                    'goods_images' => $imagesName
                ]);
                session()->setFlashdata('success', 'Barang berhasil di tambahkan');
                return redirect()->to('/goods');
            }
        } else {
            $data = [
                'title' => 'Create New Goods',
                'category' => $this->Category->getAll(),
            ];
            return view('pages/all/goods_create', $data);
        }
    }

    public function edit($slug)
    {
        $goods = $this->Goods->getOneData($slug);
        unset($goods['id']);
        $category = $this->Category->getCategoryById($goods['goods_category']);
        $goods['goods_category'] = $category['category_name'];
        $goods['created_at'] = Time::parse($goods['created_at'], 'Asia/Jakarta', 'id-ID')->humanize();
        $goods['updated_at'] = Time::parse($goods['updated_at'], 'Asia/Jakarta', 'id-ID')->humanize();

        $data = [
            'title' => "Edit Goods",
            'goods' => $goods,
            'category' => $this->Category->getAll(),
        ];

        return view('pages/all/goods_update', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();
        $goods = $this->Goods->getOneData($data['goods_code']);
        unset($data['goods_code']);
        if ($data) {
            if ($data['goods_category'] == 0) {
                $data['goods_category'] = "";
            }

            if ($data['goods_category'] != "") {
                $category = $this->Category->getCategory($data['goods_category']);
                $data['goods_category'] = $category['id'];
            }

            if ($data['goods_stok'] == "") {
                $data['goods_stok'] = "0";
            }

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
                'goods_category' => $data['goods_category'],
                'goods_name' => $data['goods_name'],
                'goods_description' => $data['goods_description'],
                'goods_price' => $data['goods_price'],
                'goods_prev_price' => $data['goods_prev_price'],
                'goods_stok' => $data['goods_stok'],
                'goods_min_stok' => "0",
            ];

            $images = $this->request->getFile('goods_images');
            if ($images->isValid()) {
                if ($goods['goods_images'] != 'dummyimages.jpg') {
                    unlink('assets/images/uploads/' . $goods['goods_images']);
                }
                $randomName = $images->getRandomName();
                $images->move('assets/images/uploads', $randomName);
                $data += ['goods_images' => $images->getName()];
            }

            $this->Goods->update($goods['id'], $data);
            session()->setFlashdata('success', 'Barang berhasil di update');
            return redirect()->to('/goods');
        }
    }
}
